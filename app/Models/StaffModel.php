<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

use App\Models\ApartmentModel; //公寓表
use App\Models\DormitoryModel; //入住表

use DB;

class StaffModel extends Model
{

	protected $table = "staff";
    protected $guarded    = [];
    public    $timestamps = true;  //不采用时间戳

    public function myAdd ($request)
    {

        #1 接受所有参数
        $data =  $request->except('_token','g_id','f_id');


        $g_id = $request->g_id; //公寓ID
        $f_id = $request->f_id; //房间ID

        // 查询该房间 是否满员
        $apartment = ApartmentModel::where(['id' => $f_id])->first();

        // 算出剩余人数
        if ( $apartment->resident_number <= $apartment->checked_number ) {
            return ['code' => 0 ,'msg' => '该房间已满员'];
        }

        //房间数+1
        $apartment->increment('checked_number');


        //添加入住表
        DormitoryModel::create([
            'g_id' => $g_id,
            'f_id' => $f_id,
            'number' => $request->number
        ]);


        #2 数据验证
        if ( $error = $this->checkValidate($data) )
            return ['code' => 0, 'msg' => $error];

        #3 数据添加
        if ( self::create($data) )
            return ['code' => 1, 'msg' => '添加成功'];
        else
            return ['code' => 0, 'msg' => '添加失败'];
    }


    public function myEdit($request, $id)
    {
        #1 接受所有参数
        $data =  $request->except('_token','_method','one-department','g_id','f_id','old_f_id');

        $g_id = $request->g_id;         //公寓ID

        $f_id = $request->f_id;         //房间ID
        $old_f_id = $request->old_f_id; //旧的房间ID

        //return  "公寓:".$g_id . "房间：".$f_id;

        $dormitoryStatus = 1;



        $staff = self::where('number',$request->number)->first();
        $apartment = ApartmentModel::where('id',$f_id)->first();

        // 离职 原始状态
        if ( $request->status == 2 && $staff->status == 1 ) {
            DB::table('apartment')->where('id',$f_id)->decrement('checked_number');
            $dormitoryStatus = 2;
            //更新入住表
            DormitoryModel::where(['number' => $request->number])->update([
                'status' => $dormitoryStatus,
                'g_id'   => $g_id,
                'f_id'   => $f_id,
            ]);
        }







        // 在职   原始是离职状态
        if ( $request->status == 1 && $staff->status == 2 ) {

            //检测该房间是否满员
            if ( $apartment->resident_number - $apartment->checked_number > 0 ) {
                DB::table('apartment')->where('id',$f_id)->increment('checked_number');
            } else {
                return ['code' => 0, 'msg' =>'该房间满员'];
            }

            $dormitoryStatus = 1;

            //更新入住表
            DormitoryModel::where(['number' => $request->number])->update([
                'status' => $dormitoryStatus,
                'g_id'   => $g_id,
                'f_id'   => $f_id,
            ]);

        }


        //在职  并且是在职状态
        if ( $request->status == 1 && $staff->status == 1 ) {
            // 新旧是否有更新
            if ($f_id != $old_f_id) {
                //检测该房间是否满员
                if ( $apartment->resident_number - $apartment->checked_number > 0 ) {
                    DB::table('apartment')->where('id',$f_id)->increment('checked_number');
                    DB::table('apartment')->where('id',$old_f_id)->decrement('checked_number');
                } else {
                    return ['code' => 0, 'msg' =>'该房间满员'];
                }

                //更新入住表
                DormitoryModel::where(['number' => $request->number])->update([
                    'status' => $dormitoryStatus,
                    'g_id'   => $g_id,
                    'f_id'   => $f_id,
                ]);

            }
        }






        #2 数据验证
        if ( $error = $this->checkValidate($data,$id) )
            return ['code' => 0, 'msg' => $error];

        #3 数据修改
        if ( self::where('id',$id)->update($data) !== false )
            return ['code' => 1, 'msg' => '修改成功'];
        else
            return ['code' => 0, 'msg' => '修改失败'];
    }



    /*****表关联******/

        //关联部门
        public function department()
        {
            return $this->belongsTo('App\Models\DepartmentModel','department_id');
        }


        //关联薪资结构
        public function salary()
        {
            return $this->belongsTo('App\Models\SalaryStructureModel','salary_structure_id');
        }

        //关联管理宿舍
        public function dormitory()
        {
            return $this->belongsTo('App\Models\DormitoryModel','number','number');
        }

        //关联角色
        public function roles()
        {
            return $this->belongsTo('App\Models\Rbac\RoleModel','role_id');
        }

        // 关联其他岗位工资
        public function otherpost()
        {
            return $this->belongsTo('App\Models\OtherPosts','number','number');
        }

        // 关联流水表
        public function FlowingWater()
        {
            return $this->belongsTo('App\Models\FlowingWaterModel','number','number');
        }

    /*****表关联******/



    /*******表单验证*******/
    protected function checkValidate($data,$id = null)
    {
        $messages = [
            'number.unique'  => '该ID已存在',
        ];
        $role = [
            'number'     => [ Rule::unique('staff')->ignore($id,'id') ],
        ];
        $validator = \Validator::make($data, $role, $messages);
        if ($validator->fails()) {
            $error_msg = $validator->errors()->first();
            return $error_msg;
        }
        return false;
    }



}
