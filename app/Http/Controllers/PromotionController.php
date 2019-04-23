<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\StaffModel;                 //员工
use App\Models\DepartmentModel;            //部门
use App\Models\DepartmentFlowModel;        //部门流水
use App\Models\SpecialPositionScorelModel; //特殊岗位评分
use App\Models\FlowingWaterModel; //个人流水
use App\Models\OtherPosts; //公共工资表
use App\Models\ExchangeRateModel; //获取汇率

class PromotionController extends CommonController
{


    public function index(Request $request)
    {
        /***获取推广部数据***/
        $promotions = (new DepartmentModel())->where('pid',3)->get();

        /*********默认调出 id为4 v1组下面的小组**********/
        $id = 4;
        if ($request->has('id')) {
            $id = $request->id;
        }
        $groups = (new DepartmentModel())->where('pid',$id)->get();

        $datas = [];
        foreach ($groups as $k => $value) {
            //获取部门流水
            $datas['v'][$k]['price'] = (new DepartmentFlowModel())
                ->where('department_id',$value['id'])
                ->get();

            //获取当前部门特殊岗位评分
            $datas['v'][$k]['special_position_score'] = (new SpecialPositionScorelModel())->where('department_id',$value['id'])->first();

            $datas['v'][$k]['name'] = $value['name']; //小组名字
            $datas['v'][$k]['id']   = $value['id'];   //小组ID

            //获取当前小组的员工
            $datas['v'][$k]['data'] =
                        (new StaffModel())
                        ->where(['department_id' => $value['id'],'status' => 1])
                        ->with('salary','FlowingWater','otherpost')
                        ->get();

        }

        /*********默认选中*************/
        $active = $id;

        return view('promotion.index',compact('promotions','active','datas'));
    }

    //绩效计算
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {

            // 1. 接受员工编号ID
            $number = $request->number;

            //员工表
            $StaffModel = (new StaffModel())
                            ->where('number',$number)
                            ->first();

            /******检测是否添加该岗位特殊频分********/
            $spsmBool = SpecialPositionScorelModel::where('department_id',$StaffModel->department_id)->first();
            if ($spsmBool == null) {
                return ['code' => 0,'msg' => '请先设置该组特殊岗位评分'];
            }


            /************初始化变量*****************/
            $totalFraction = 0; //得分
            $point = 0;         //有效数

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

            /***************
            * 检测是特殊岗位 or 推广岗位
            * 计算不同岗位的提成
            ^ 1 推广
            ^ 2 特殊
            ***************/
            $fraction_money = 0; //得分金额
            $point_money    = 0; //有效数金额
            $total_moeny    = 0; //总金额
            $group_moeny    = 0; //组长金额
            $special_moeny  = 0; //特殊金额

            if ( $StaffModel->business_type == 1 ) {
                /*******推广岗类型计算**********/

                // 1. 检测是否转正    1转正  0未转正
                if ( $StaffModel->is_formal == 1 ) {

                    $fraction_money = $totalFraction * 50 * 0.7;  //得分计算

                    //有效数计算
                    if ( $point >= 16 ) {
                        $point_money = 2000;
                    } elseif($point >= 15){
                        $point_money = 1100;
                    } elseif($point >= 14){
                        $point_money = 600;
                    } else {
                        $point_money = 0;
                    }

                } else {
                    // 未转正
                    $fraction_money = $totalFraction * 50 * 0.6; //得分计算
                     //有效数计算
                    if ( $point >= 16 ) {
                        $point_money = 2000;
                    } elseif($point >= 15){
                        $point_money = 1100;
                    } elseif($point >= 14){
                        $point_money = 600;
                    } else {
                        //新人前2个月有效数福利
                        if ( $point >= 10 ) {
                            $point_money =  500;
                        } elseif( $request->month == 1 && $point >= 5 ) {
                            $point_money =  500;
                        } elseif( $request->month == 2 && $point >= 8 ) {
                            $point_money = 500;
                        } else {
                            $point_money =  0;
                        }
                    }
                }

                $total_moeny = $fraction_money +  $point_money; //总金额
            } else {
                /*******特殊岗类型计算**********/


                $score = SpecialPositionScorelModel::where('department_id',$StaffModel->department_id)->first()->score; //获得频分

                //判断是组长 还是特殊组员 组长ID：6
                if ( $StaffModel->salary->name == "组长" ) {
                    if ($score >= 100) {
                        $group_moeny = 2000;
                    } elseif($score >= 90) {
                        $group_moeny = 1100;
                    } elseif($score >= 80){
                        $group_moeny = 600;
                    } else {
                        $group_moeny = 0;
                    }
                } else {
                    // 特殊组员
                    if ( $StaffModel->salary->name == "推广主管" ) {
                        if ( $score >= 80 ) {
                            $special_moeny = 2000;
                        }
                    }
                }

                $total_moeny = $group_moeny + $special_moeny; //总金额


            }





             //创建或更新 流水表
            (new FlowingWaterModel())->updateOrCreate(
                ['number' => $number],
                ['number' => $number,'fraction'=> $totalFraction,'point' => $point,'month' => $request->month,'fractional_column' => $fractional_column,'is_input' => 1,'fraction_money' => $fraction_money,'point_money'=>$point_money,'total_moeny'=>$total_moeny,'group_moeny'=>$group_moeny,'special_moeny'=>$special_moeny
                ]
            );

            /******
            *团队里面的额度初始化 贡献金额流入部门奖金盒子
            ******/
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
            (new DepartmentFlowModel())->updateOrCreate(
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

             //视图展示

             //获取员工信息
            $staff = (new StaffModel())->where('number',$request->number)->first();
            //获取业绩信息
            $flowingWater = (new FlowingWaterModel())->where('number',$request->number)->first();
            //分数列数回显
            if ( isset($flowingWater->fractional_column) ) {
                $fractional_column = str_replace(',',"\n",$flowingWater->fractional_column);
            } else {
                $fractional_column = 0;
            }
            return view('promotion.add',compact('staff','flowingWater','fractional_column'));
        }
    }

    //工资计算
    public function calculation(Request $request)
    {
        if ($request->isMethod('post')) {
            return 'post';
        } else {
            $other  = (new OtherPosts())->where('number',$request->number)->first();
            $number = $request->number;
            return view('promotion.calculation',compact('other','number'));
        }
    }

    //查看
    public function see(Request $request)
    {
        //获取员工唯一编号
        $number = $request->number;

        $other  = (new OtherPosts())->where('number',$request->number)->first();
        $flowingWater = (new FlowingWaterModel())->where('number',$request->number)->first();

        $flag = true;
        if ( $other == null || $flowingWater == null ) {
            $flag = false;
        }
        $rate = ExchangeRateModel::first()->rate;
        return view('promotion.see',compact('other','flowingWater','flag','rate'));
    }


    //设置特殊岗位评分
    public function specialPositionScore(Request $request)
    {
        $department_id = $request->department_id;
        $score         = $request->score;

        (new SpecialPositionScorelModel())->updateOrCreate(
            ['department_id' => $department_id],
            [
                'score' => $score,
            ]
        );
        return ['code' => 1, 'msg' => '设置成功'];
    }


    // 清空
    public function clear(Request $request)
    {
        //流水
        (new FlowingWaterModel())->where('id','>',0)->delete();
        //部门流水
        (new DepartmentFlowModel())->where('id','>',0)->delete();
        //特殊岗位评分
        (new SpecialPositionScorelModel())->where('id','>',0)->delete();
        //基本工资
        (new OtherPosts())->where('id','>',0)->delete();

        return ['code' => 1,'msg' => '清除成功,请等候跳转!'];
    }



}
