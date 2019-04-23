<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalaryStructureController extends CommonController
{
    
	protected $SalaryStructureModel;
	protected $DepartmentModel;

    public function __construct()
    {
        /*实例化model*/
        $this->SalaryStructureModel = new \App\Models\SalaryStructureModel();
        $this->DepartmentModel = new \App\Models\DepartmentModel();
    }


    public function index()
    {
        $datas = $this->SalaryStructureModel->getTree();
        return view('salaryStructure.index',['datas'=>$datas]);
    }



    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            return  $this->SalaryStructureModel->myAdd($request);
        } else {
            $OneTree = $this->SalaryStructureModel->where('pid',0)->get();

            $oneDepartment = $this->DepartmentModel->where('level',1)->get();

            return view('salaryStructure.add',['OneTree' => $OneTree,'oneDepartment' => $oneDepartment]);
        }
    }


    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            return  $this->SalaryStructureModel->myEdit($request,$request->id);
        } else {
            $data = $this->SalaryStructureModel->find($request->id);
            $oneDepartment = $this->DepartmentModel->where('level',1)->get();
            return view('salaryStructure.edit',['data' => $data,'oneDepartment'=>$oneDepartment]);
        }
    }



}
