<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessController extends CommonController
{
    
	protected $StaffModel;  	        //员工
	protected $DepartmentModel;         //部门
	protected $SalaryStructureModel;    //部门薪资

	protected $FlowingWaterModel;            //流水
	protected $DepartmentFlowModel;          //部门流水      
	protected $SpecialPositionScorelModel;   //特殊岗位评分
    protected $ExchangeRateModel;            //汇率

    public function __construct()
    {
        /*实例化model*/
        $this->DepartmentModel      = new \App\Models\DepartmentModel();
        $this->StaffModel           = new \App\Models\StaffModel();
        $this->SalaryStructureModel = new \App\Models\SalaryStructureModel();

     	$this->FlowingWaterModel            = new \App\Models\FlowingWaterModel();
     	$this->DepartmentFlowModel          = new \App\Models\DepartmentFlowModel();
     	$this->SpecialPositionScorelModel   = new \App\Models\SpecialPositionScorelModel();
        $this->ExchangeRateModel            = new \App\Models\ExchangeRateModel();
    }


    //推广首页
	public function index(Request $request)
	{

		/******初始化数据盒子*******/
        $datas = [];

        /***获取推广部数据***/
        $datas['extensionGroups'] = $this->DepartmentModel::where('pid',3)->get();

        /*********默认调出 id为4 v1组下面的小组**********/
        $id = 4;
        if ($request->has('id')) {
            $id = $request->id;
        }
        $datas['departments'] = $this->DepartmentModel->where('pid',$id)->get();


        //遍历当前V组
        foreach ($datas['departments'] as $k => $value) {
            
            //获取当前部门流水
            $datas['v'][$k]['price'] = $this->DepartmentFlowModel->where('department_id',$value['id'])->get();

            //获取当前部门特殊岗位评分
            $datas['v'][$k]['special_position_score'] = $this->SpecialPositionScorelModel->where('department_id',$value['id'])->first();
           
            $datas['v'][$k]['name'] = $value['name']; //小组名字
            $datas['v'][$k]['id']   = $value['id'];   //小组ID

            //获取当前小组的员工
            $datas['v'][$k]['data'] = 
                        $this->StaffModel 
                        ->where(['department_id' => $value['id'],'status' => 1])
                        ->with('salary')
                        ->get();
        }



        /*********获取汇率*************/
        $datas['rate'] = $this->getExchangeRate();
       
        /*********默认选中*************/
        $datas['active'] = $id;


        return view('business.index')->with('datas',$datas);
    }


    //添加业绩
    public function achievementAdd(Request $request)
    {
        if ( $request->isMethod('post') ) {

            // 1. 接受员工编号ID
            $number = $request->number;

            /*******初始化得分********/
            $totalFraction = 0;

            /*******初始化有效数********/
            $point = 0;

            //计算 得分 有效数
            $total_score = explode("\n", $request->total_score);

            $fractional_column = null;

            foreach ($total_score as $key => $value) {
                if ( $value > 0 ) {
                    $point += 1;
                }
                $totalFraction += intval($value);
               
                $fractional_column .= $value.",";
            }

            // 2. 创建或更新 流水表
            $FlowingWater_rs =  $this->FlowingWaterModel->updateOrCreate(
                ['number' => $number],
                ['number' => $number,'fraction'=> $totalFraction,'point' => $point,'attendance_days' => $request->attendance_days,'month' => $request->month,'fractional_column' => $fractional_column
                ]
            );


            //员工表 查询该ID是特殊岗还是推广岗
            $StaffModel = $this->StaffModel
                            ->where('number',$number)
                            ->first();

            //团队里面的额度初始化 贡献金额流入部门奖金盒子
            $total_amount = 0;
            
            if ( $StaffModel->business_type == 1 ) {
                
                //推广岗位

                /*****判断该员工是否转正******/
                if ( $StaffModel->is_formal == 1 ) {
                    $total_amount += $totalFraction * 50 * 0.3;
                } else {
                    $total_amount += $totalFraction * 50 * 0.4;
                }

            } else {
                //特殊岗位
                $total_amount +=  $totalFraction * 50;
            }


            // 创建或修改部门奖金盒子
            $department_id = $request->department_id;
            $FlowingWater_rs =
            $this->DepartmentFlowModel->updateOrCreate(
                ['number' => $number],
                [
                    'number' => $number,
                    'fraction' => $totalFraction,
                    'total_amount'=> $total_amount,
                    'department_id' => $department_id
                ]
            );

            return ['code' => 1, 'msg' => '操作成功'];

        } else {

            //获取员工信息
            $staff = $this->StaffModel->where('number',$request->number)->first();

            //获取业绩信息
            $flowingWater = $this->FlowingWaterModel->where('number',$request->number)->first();

            //分数列数回显
            if ( isset($flowingWater->fractional_column) ) {
                $fractional_column = str_replace(',',"\n",$flowingWater->fractional_column);
            } else {
                $fractional_column = 0;
            }

            return view('business.achievementAdd')
                ->with('staff',$staff)
                ->with('flowingWater',$flowingWater)
                ->with('fractional_column',$fractional_column);
        }
    }


    /***************
    *查看绩效
    *
    ***************/
    public function viewPerformance (Request $request)
    {
        //获取员工唯一编号
        $number = $request->number;

        /***************
        * 获取流水
        *
        ***************/
        $flowingWater = $this->FlowingWaterModel->where('number' , $request->number)->first();
        
        //判断该ID是否录入数据
        if ( $flowingWater == null ) 
            return '<center><p style="color:red;margin-top:50px">该ID还未录入数据</p></center>';
        


        /***************
        * 获取员工信息
        *
        ***************/
        $staff = $this->StaffModel->where('number',$number)->first();

        //判断该ID所属的部门是否录入特使评分
        if ( $this->SpecialPositionScorelModel->where('department_id',$staff->department_id)->first() == null ) 
            return '<center><p style="color:red;margin-top:50px">请先设置该部门特殊岗评分</p></center>';
             

        /***************
        * 格式化变量
        *
        ***************/

        //获取该ID转正字段
        $is_formal = $staff['is_formal'];

        //获取职位基本薪资
        $salary = $staff['salary']['salary'];

        //获取提成点数
        $fraction =  $flowingWater['fraction'];

        //获取有效数
        $point =  $flowingWater['point'];

        //获取到勤天数
        $attendance_days = $flowingWater['attendance_days'];

        //获取新人未转正月份
        $month =  $flowingWater->month;


         //封装数据
        $staff['attendance_days_25'] = ($salary / 25) * $attendance_days;

        $staff['attendance_days'] = $attendance_days;

        $staff['zuzhang'] = 0;  //设置组长默认金额
        $staff['ts'] = 0;      // 设置特殊默认金额

        /***********开始计算***********/

        $totalPrice = 0; //总额

        //岗位基本工资
        $totalPrice = $totalPrice + $staff['attendance_days_25'];


        //入职时间戳
        $date_of_entry =  strtotime($staff['date_of_entry']);

        //入职日期在这个月里面浮动 比如6月1 - 6月30
        $current_time = strtotime(date('Y-m-30', strtotime('-1 month')));


        //计算工龄
        $working_years = intval( ( $current_time - $date_of_entry  ) / 31536000);


        // 基本工资 + 工龄
        $totalPrice = $totalPrice + ($working_years * 500); //年限 * 工龄



        /***************
        * 检测是特殊岗位 or 推广岗位
        * 计算不同岗位的提成
        ***************/
        // 1.推广  2.特殊
        if ( $staff->business_type == 1 ) {
           
            /************以下推广***************/


            // 转正or未转正
            if ($is_formal == 1) {

                $totalPrice = $totalPrice + ($fraction * 50 * 0.7);

                if ($point >= 16) {
                    $totalPrice = $totalPrice + 2000;
                } elseif($point >= 15){
                    $totalPrice = $totalPrice + 1100;
                } elseif($point >= 14){
                    $totalPrice = $totalPrice + 600;
                } else {
                    $totalPrice = $totalPrice + 0;
                }

            } else {

                $totalPrice = $totalPrice + ($fraction * 50 * 0.6);

                if ($point >= 16) {
                    $totalPrice = $totalPrice + 2000;
                } elseif($point >= 15){
                    $totalPrice = $totalPrice + 1100;
                } elseif($point >= 14){
                    $totalPrice = $totalPrice + 600;
                } else {

                    if ( $point >= 10 ) {
                        $totalPrice = $totalPrice + 500;
                    } elseif( $month == 1 && $point >= 5 ) {
                        $totalPrice = $totalPrice + 500;
                    } elseif( $month == 2 && $point >= 8 ) {
                        $totalPrice = $totalPrice + 500;
                    } else {
                        $totalPrice = $totalPrice + 0;
                    }

                }


            }

        } else {


            //特殊  组长 == 普通

            // 获取特殊岗位分数
            $sps = $this->SpecialPositionScorelModel->where('department_id',$staff->department_id)->first();

            $sps_score = $sps->score; //分数

            // 数据库中 组长ID是6
            if ( $staff->salary->name == "组长"  ) {

                if ($sps_score >= 100) {
                    $staff['zuzhang'] = 2000;
                } elseif($sps_score >= 90) {
                    $staff['zuzhang'] = 1100;
                } elseif($sps_score >= 80){
                    $staff['zuzhang'] = 600;
                } else {
                    $staff['zuzhang'] = 0;
                }

                $totalPrice += $staff['zuzhang'];

            } else {
                // ts
                if ($staff->salary->name != '推广主管') {
                    if ( $sps_score >= 80 ) {
                       $staff['ts'] = 2000;
                    }
                }
                $totalPrice += $staff['ts'];
            }

        } //给岗位员工提成统计END

        //封装数据
        $staff['working_years'] = $working_years;

        $staff['fws']  = $flowingWater;

        $staff['totalPrice'] = $totalPrice;

        $staff['month'] = $month;

        $staff['rate'] = $this->getExchangeRate(); //获取当前汇率

        $staff['local_exchange_rate'] = $totalPrice * $staff['rate']; //本地汇率

        return view('business.viewPerformance',['staff' => $staff]);
    } 



    /***************
    *获取汇率
    *
    ***************/
    public function getExchangeRate()
    {
        $rs = $this->ExchangeRateModel->first();
        return $rs->rate; //获取当前汇率
    }


    /***************
    *特殊岗位评分设置
    *
    ***************/
    public function specialPositionScore(Request $request)
    {
        $department_id = $request->department_id;
        $score         = $request->score;

        $this->SpecialPositionScorelModel->updateOrCreate(
            ['department_id' => $department_id],
            [
                'score' => $score,
            ]
        );

        return ['code' => 1, 'msg' => '设置成功'];
    }


    /***************
    *清除推广所有数据
    *
    ***************/
    public function clear()
    {
        //流水
        $this->FlowingWaterModel->where('id','>',0)->delete();    
        //部门流水              
        $this->DepartmentFlowModel->where('id','>',0)->delete();     
        //特殊岗位评分     
        $this->SpecialPositionScorelModel->where('id','>',0)->delete();   

        return ['code' => 1,'msg' => '清除成功,请等候跳转!'];
    }

}
