<?php

namespace App\Http\Controllers\Rbac;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    

	protected $roleModel;
    protected $menuModel;

    public function __construct()
    {
        /*实例化model*/
        $this->roleModel = new \App\Models\Rbac\RoleModel();
        $this->menuModel = new \App\Models\Rbac\MenusModel();
    }



    public function index()
    {
        $datas = $this->roleModel->get();
        return view('rbac.role.index',['datas' => $datas]);
    }


    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            return  $this->roleModel->myAdd($request);
        } else {
            return view('rbac.role.create');
        }
    }


    public function edit(Request $request)
    {   
        if ($request->isMethod('post')) {
            return  $this->roleModel->myEdit($request,$request->id);
        } else {
            $data  = $this->roleModel->find($request->id);
            return view('rbac.role.edit',['data' => $data]);
        }  
    }



    /**********
    * 为角色设置权限
    *
    **********/
    public function setAuth(Request $request)
    {
    	if ($request->isMethod('post')) {
          
            $auth_ids = rtrim($request->auth_ids, ","); 
            
            $this->roleModel->where('id',$request->id)->update(['auth_ids'=>$auth_ids]);
           
           return ['code' => 1,'msg' => '设置成功'];

        } else {
            
            //角色id
            $role_id = $request->id; 

            //获取所有权限
            $auths   =  $this->menuModel->getTree();  

            //获取属于这个角色的权限
            $role_ids = $this->roleModel->find($role_id);
           
            $roles = [];
            //让每个建值+1
            foreach (explode(",",$role_ids['auth_ids']) as $key => $value) {
                $roles[$key + 1] = $value;
            }

            //定义返回数据的数组
            $authArr = [];
            //依次遍历查找如果权限表中匹配 注入 'checked' => true
            foreach ($auths as $key => $value) {
               if ( array_search($value['id'],$roles) ) {
                  $value['checked'] = true;
                  $authArr[$key] = $value;
               } else {
                  $value['checked'] = false;
                  $authArr[$key] = $value;
               }
            }

            $returnAuths =  json_encode($authArr);
           
            // 返回视图
            return view('rbac.role.setauth',['role_id' =>$role_id, 'auths' => $returnAuths]);
        }
    }

}
