<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends CommonController
{
    

	protected $DepartmentModel;

    public function __construct()
    {
        /*实例化model*/
        $this->DepartmentModel = new \App\Models\DepartmentModel();
    }


    public function index()
	{
		$datas = $this->DepartmentModel->getTree();
		return view('department.index',['datas'=>$datas]);
	}


	public function add(Request $request)
	{
		if ($request->isMethod('post')) {
			return  $this->DepartmentModel->myAdd($request);
		} else {
            $trees = $this->DepartmentModel->getTree();
			return view('department.add',['trees' => $trees]);
		}
	}


	public function edit(Request $request)
	{
		if ($request->isMethod('post')) {
			return  $this->DepartmentModel->myEdit($request,$request->id);
		} else {
			$data = $this->DepartmentModel->find($request->id);
			return view('department.edit',['data' => $data]);
		}
	}


}
