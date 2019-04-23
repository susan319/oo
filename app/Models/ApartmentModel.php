<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use App\Models\DormitoryModel;

class ApartmentModel extends Model
{
    
	protected $table = "apartment";
    protected $guarded    = [];
    public    $timestamps = false;  //不采用时间戳


    public function myAdd ($request)
    {
        #1 接受所有参数
        $data =  $request->except('_token');

        #3 数据添加
        if ( self::create($data) )
            return ['code' => 1, 'msg' => '添加成功'];
        else
            return ['code' => 0, 'msg' => '添加失败'];
    }



    public function myEdit ($request, $id)
    {
        #1 接受所有参数
        $data =  $request->except('_token','_method');

        #3 数据修改
        if ( self::where('id',$id)->update($data) !== false )
            return ['code' => 1, 'msg' => '修改成功'];
        else
            return ['code' => 0, 'msg' => '修改失败'];
    }


    // 公寓Tree
    public function getTree()
    {
        //查询所有数据
        $data  = self::where('status',1)->get();
        return $this->_reSort($data);
    }

    private function _reSort($data, $cat_pid=0, $isClear=TRUE)
    {
        static $ret = array();
        if($isClear)
            $ret = array();

        foreach ($data as $k => $v)
        {
            if($v['pid'] == $cat_pid)
            {
                $ret[] = $v;
                $this->_reSort($data, $v['id'], FALSE);
            }
        }
        return $ret;
    }


    /**********公寓下面的房间************/
    public function getChildren($id)
    {
        $data  = self::all();
        return $this->_children($data, $id);
    }

    private function _children($data, $cat_pid=0, $isClear=TRUE)
    {
        static $ret = array();

        if($isClear)
            $ret = array();

        foreach ($data as $k => $v)
        {
            if($v['pid'] == $cat_pid)
            {
                $ret[$k] = $v;
                $ret[$k]['peoples'] = DormitoryModel::where(['status'=>1,'f_id'=>$v['id']])->with('staff','staff.department')->get();

                $this->_children($data, $v['id'], FALSE);
            }
        }
        return $ret;
    }





}
