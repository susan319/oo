<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends CommonController
{
    
	protected $StaffModel;
	protected $DepartmentModel;
    protected $SalaryStructureModel;

    protected $ApartmentModel;  //公寓表
    protected $DormitoryModel;  //入住表

    protected $RoleModel;       //角色


    public function __construct()
    {
        /*实例化model*/
        $this->StaffModel           = new \App\Models\StaffModel();
        $this->DepartmentModel      = new \App\Models\DepartmentModel();
        $this->SalaryStructureModel = new \App\Models\SalaryStructureModel();

        $this->ApartmentModel       = new \App\Models\ApartmentModel();
        $this->DormitoryModel       = new \App\Models\DormitoryModel();

        $this->RoleModel            = new \App\Models\Rbac\RoleModel();
    }


    public function index(Request $request)
	{
	
        $status        = $request->status ? $request->status : 1;
        $department_id = $request->department_id;
        $number        = $request->number;

        $search        =  $this->StaffModel->with('department','salary','dormitory','roles');

        $total = $search->where('status',1)->count();

        $status && $search->where('status',$status);
        $number && $search->where('number',$number);
        $department_id && $search->where('department_id',$department_id);

        $all = $search->paginate(8);

        //部门树
        $departments = $this->DepartmentModel->getTree();

		return view('staff.index',['departments' => $departments])
            ->with(array('all'=>$all,'status'=>$status,'number' => $number,'department_id' => $department_id))
            ->with('total',$total);
	}






    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            return  $this->StaffModel->myAdd($request);
        } else {

            //一级部门树
            $department_ones = $this->DepartmentModel->getOneLevel();

            //获取一级公寓
            $apartmen_ones   = $this->ApartmentModel->where(['level'=>1,'status'=>1])->get();


            //获取角色
            $roles = $this->RoleModel->where('status',1)->get();

            return view('staff.add')
                    ->with('department_ones',$department_ones)
                    ->with('apartmen_ones',$apartmen_ones)
                    ->with('roles',$roles);
        }
    }


    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            return  $this->StaffModel->myEdit($request,$request->id);
        } else {

            //一级部门树
            $department_ones = $this->DepartmentModel->getOneLevel();
            
            //员工基本数据
            $data = $this->StaffModel->find($request->id);

            //查找员工入住表
            $data['dormitory'] = $this->DormitoryModel->where('number',$data['number'])->first();

            //它属于那个顶级部门
            $data['topDepartment'] = getPrentDepartmentID($data->department_id);
           
            //获取一级公寓
            $apartmen_ones  = $this->ApartmentModel->where(['level'=>1,'status'=>1])->get();

            //获取角色
            $roles = $this->RoleModel->where('status',1)->get();

            return view('staff.edit',['data' => $data,'department_ones' => $department_ones,'apartmen_ones' => $apartmen_ones,'roles'=>$roles]);
        }
    }



    public function todaysBirthday(Request $request)
    {
        $today = date('m-d',time()); //获取当前月份与当前日

        $datas = $this->StaffModel->where(['age' => $today, 'status' => 1])->with('department')->get();

        return view('staff.todaysBirthday',['datas' => $datas,'today' => $today]);
    }



    /**********
    * 根据部门ID获取子部门及该部门的薪资结构
    *
    **********/
    public function subsidiary(Request $request)
    {
        $data = [];

        $department_id = $request->department_id;

        //获取子部门
        $departments = $this->DepartmentModel->getChildren($department_id);
        
        //获取子部门薪资
        $SalaryStructure = $this->SalaryStructureModel->where('remarks',$request->remarks)->get();
        
        $data['departments'] = $departments;
        $data['SalaryStructure'] = $SalaryStructure;

        return $data;
    }



}
