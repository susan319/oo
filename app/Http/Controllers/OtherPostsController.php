<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\StaffModel;
use App\Models\DepartmentModel;
use App\Models\OtherPosts; 

class OtherPostsController extends Controller
{
    protected $DepartmentModel;         //部门
    protected $OtherPostsModel;         //其他
    protected $ExchangeRateModel;        //汇率

    public function __construct()
    {
    	$this->DepartmentModel = new \App\Models\DepartmentModel();
    	$this->OtherPostsModel = new \App\Models\OtherPosts();
    	$this->ExchangeRateModel  = new \App\Models\ExchangeRateModel();
    } 


    /****显示部门列表****/
	public function index(Request $request)
	{
		$datas = [];
		
		/*********默认调出 id为2  调出行政的数据 **********/
        $id = 2;
        if ($request->has('id')) {
            $id = $request->id;
        }

		//获取除推广岗位以外的所有岗位
		$datas['department'] = $this->DepartmentModel
								->where('level','1')
								->whereNotIn('id',[3])
								->get();

        $Department_id = DepartmentModel::where('pid',$id)->first();							

		$staffs = StaffModel::where('department_id',$Department_id->id)->with('salary','otherpost')->get();

		/*********默认选中*************/
        $datas['active'] = $id;

		return view('otherpost.index')
			->with('datas',$datas)
			->with('staffs',$staffs);
	}

	/*******薪水计算********/
	public function calculation(Request $request)
	{

		if ( $request->isMethod('post') ) {

			//1. 获取岗位数据  薪资数据
			$staff = StaffModel::where('number',$request->number)->where('status',1)->with('salary')->first();

			//总金额 默认0
			$totalSum = 0;

			$salary_id = $staff->salary->id;   //薪水ID   
			$salary    = $staff->salary->salary;  //岗位基本薪资

			$days          = $request->attendance_days; //上班天数
			$remarks_money = $request->remarks_money; //获取备注 金额
			$basic_salary = 0; //基本工资

			// IT部特定id 5,12  计算基本和加班工资
			if ( $salary_id == 5 || $salary_id == 12 ) {
				if ( $days <= 22 ) {
					$totalSum = $salary / 22 * $days;
				} else {
					$totalSum = $salary + $salary / 30 * ($request->attendance_days - 22);
				}
			} else {
				if ( $days <= 25 ) {
					$totalSum = $salary / 25 * $days;
				} else {
					$totalSum = $salary + $salary / 30 * ($request->attendance_days - 25);
				}
			}
			
			
			$basic_salary = $totalSum;
			$tempMoneyRemarksMoney = 0;
			foreach ( json_decode($remarks_money, true) as $key => $value) {
				 $tempMoneyRemarksMoney += $value['money'] ;
			}
			$totalSum =  $totalSum + $tempMoneyRemarksMoney;
			
			//其他岗位 数据入库 
			$this->OtherPostsModel->updateOrCreate(
				['number'=>$request->number],
				['number'=>$request->number,'remarks_money'=>$remarks_money,'hydropower'=>$request->hydropower,'attendance_days'=>$days,'is_input'=>1,'total_price'=>$totalSum,'basic_salary'=>$basic_salary]
			);

			return ['code' => 1,'msg' => '操作成功'];

		} else {

			$rs = $this->OtherPostsModel->where('number',$request->number)->first();			
			return view('otherpost.calculation')->with('number',$request->number)->with('rs',$rs);
		}
	}


	/*****薪水查看*****/
	public function see(Request $request)
	{
		$rs   = $this->OtherPostsModel->where('number',$request->number)->first();	
		$rate = $this->ExchangeRateModel->first()->rate; //获取汇率
		return view('otherpost.see',compact('rs','rate'));
	}




}
