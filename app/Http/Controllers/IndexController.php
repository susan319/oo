<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rbac\MenusModel;
use App\Models\Rbac\RoleModel;


class IndexController extends CommonController
{
    
	/**********
    * 后台首页
    *
    **********/
	public function index(Request $request)
	{

		$role_id = session('role_id');

		$roles = RoleModel::where('id',$role_id)->first();

		//获取ids
		$ids =  explode(',',$roles['auth_ids']);

		

		$firstMenus = MenusModel::whereIn('id',$ids)->where('level',1)->orderBy('order','desc')->get();



		//获取1J菜单
		//$firstMenus = MenusModel::where('level',1)->orderBy('order','desc')->get();
		
		return view('index.index')
			->with('firstMenus',$firstMenus);
	}


	/**********
    * welcome
    *
    **********/
	public function welcome()
	{
		return view('index.welcome');
	}

}
