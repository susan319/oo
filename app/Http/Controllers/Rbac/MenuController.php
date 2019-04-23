<?php

namespace App\Http\Controllers\Rbac;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\Rbac\RoleModel;
use App\Models\Rbac\MenusModel;

class MenuController extends Controller
{

	protected $MenuModel; //菜单模型

    public function __construct()
    {
        /*实例化model*/
        $this->MenuModel = new \App\Models\Rbac\MenusModel();
    }

    
	public function index()
	{
		//菜单树
		$menuTree = $this->MenuModel->getTree();
		return view('rbac.menu.index')
				->with('menuTree',$menuTree);
	}



	/***
	* 添加菜单
	**/
	public function add(Request $request) 
	{
		if ( $request->isMethod('post') ) {
			
			return $this->MenuModel->myAdd($request);

		} else {

			//菜单树
			$menuTree = $this->MenuModel->getTree();
			
			return view('rbac.menu.add')
				   	->with('menuTree',$menuTree);
		}
	}


	/***
	* 编辑菜单
	**/
	public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            return $this->MenuModel->myEdit($request,$request->id);
        } else {

            $data  = $this->MenuModel->find($request->id);

            return view('rbac.menu.edit')
            		->with('data',$data);
        }
    }



    /***
	* 删除菜单
	**/
	public function delete(Request $request)
    {
        return $this->MenuModel->myDelete($request->id);
    }


    /**********
    * 根据ID获取子菜单
    *
    **********/
    public function getSubmenu(Request $request)
    {
    	return $this->MenuModel->getChildren($request->id);
    }



}
