<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\DormitoryModel;



class ApartmentController extends CommonController
{
    
	protected $ApartmentModel;  //公寓
	protected $StaffModel;      //员工

	public function __construct()
    {
        /*实例化model*/
        $this->ApartmentModel = new \App\Models\ApartmentModel();
        $this->StaffModel     = new \App\Models\StaffModel();
    }


	public function index(Request $request)
	{
		$datas = [];
		//获取公寓
		$datas['apartment_ones'] = $this->ApartmentModel->where(['level'=>1,'status'=>1])->get();

		//默认选中
		$id =  $datas['apartment_ones'][0]['id'];
		$datas['active'] = $id;
		if ($request->has('id')) {
			$datas['active'] = $request->id;
		}

		//获取公寓Tree
		$apartments = $this->ApartmentModel->getTree();

		return view('apartment.index')
			->with('apartments',$apartments)
			->with('datas',$datas);
	}


	public function add(Request $request)
	{
		if ( $request->isMethod('post') ) {
			return $this->ApartmentModel->myAdd($request);
		} else {
			$apartment =  $this->ApartmentModel->where(['level'=>1,'status'=>1])->get();
			return view('apartment.add')
				->with('apartments',$apartment);
		}
	}


	public function edit(Request $request)
	{
		if ($request->isMethod('post')) {
			return  $this->ApartmentModel->myEdit($request,$request->id);
		} else {
			$data = $this->ApartmentModel->find($request->id);
			
			return view('apartment.edit')
				->with('data',$data);
		}
	}

	public function delete(Request $request)
	{

		$apartment = $this->ApartmentModel->find($request->id);

		if ($request->level == 1) {
			$count = $this->ApartmentModel->where('pid',$apartment->id)->get();
			if (count($count) > 0) {
				return ['code' => 0,'msg' => '该公寓还有其他房间！'];
			}
		}

		//查询该房间是否还有人住
		if ($apartment->resident_number - $apartment->checked_number !=  $apartment->resident_number) {
			return ['code' => 0, 'msg' => '该房间还有住客'];
		}

		$apartment->status = 0;
		$apartment->save();		

		return ['code' => 1,'msg' => '删除成功'];
	}



	/*****************
	*员工入住
	*
	******************/
	public function dormitory(Request $request)
	{
		$datas = [];
		//获取公寓
		$datas['apartment_ones'] = $this->ApartmentModel->where(['level'=>1,'status'=>1])->get();

		//默认选中
		$id =  $datas['apartment_ones'][0]['id'];
		$datas['active'] = $id;
		if ($request->has('id')) {
			$datas['active'] = $request->id;
		}

		$datas['data'] = $this->ApartmentModel->getChildren($datas['active']);

		return view('dormitory.index')
			->with('datas',$datas);
	}

	/*****************
	*员工入住修改
	*
	******************/
	public function dormitoryEdit(Request $request)
	{

		if ($request->isMethod('post')) {
			
			$g_id = $request->g_id;         //公寓ID 
	        $f_id = $request->f_id;         //房间ID
	        $old_f_id = $request->old_f_id; //旧的房间ID

	        if ( $f_id != $old_f_id ) {
	        	//检测该房间是否满员
	        	$apartment = $this->ApartmentModel->where('id',$f_id)->first();

	            if ( $apartment->resident_number - $apartment->checked_number > 0 ) {

	                DB::table('apartment')->where('id',$f_id)->increment('checked_number'); 
	            	DB::table('apartment')->where('id',$old_f_id)->decrement('checked_number');

	            	DormitoryModel::where(['number' => $request->number])->update([
		                'g_id'   => $g_id,
		                'f_id'   => $f_id,
		            ]);

	            } else {
	                return ['code' => 0, 'msg' =>'该房间满员'];
	            }
	        } 

	        return ['code' => 1, 'msg' => '修改成功!'];
			
		} else {
			
			$number = $request->id;

			//获取一级公寓
            $apartmen_ones = $this->ApartmentModel->where(['level'=>1,'status'=>1])->get();

			$staff = $this->StaffModel->where('number',$number)->with('department')->first();
			
			$g_id = $request->g_id;
			$f_id = $request->f_id;

			return view('dormitory.dormitoryEdit')
				->with('apartmen_ones',$apartmen_ones)
				->with('staff',$staff)
				->with('g_id',$g_id)
				->with('f_id',$f_id);
		}

	}







	/*****************
	*获取该公寓下的所有房间
	*
	******************/
	public function room(Request $request)
	{
		return $this->ApartmentModel->where(['pid' => $request->g_id,'status' => 1])->get();
	}



}































