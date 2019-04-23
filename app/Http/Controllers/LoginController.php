<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StaffModel;
use App\Models\Rbac\RoleModel;

class LoginController extends CommonController
{
    
	/***
    * 输出登录视图及验证登录数据
    *
    ***/
	public function login(Request $request)
	{
		if ( $request->isMethod('post') ) {
				
			$number = $request->number;
			$password = $request->password;

			$result = StaffModel::where(['number'=>$number,'password'=>$password])->first();
			if ($result == null) 
				return ['code'=>0,'msg'=>'账号或密码错误'];

			//获取角色名称
			$role = RoleModel::where('id',$result->role_id)->first();
			 
			session([
					'login_token'=>true,
					'role_id'=>$result->role_id,
					'number'=>$result->number,
					'nick_name'=>$result->nick_name,
					'role_name'=>$role->name,
					'department_id' => $result->department_id
				]);
			return ['code'=>1,'msg'=>'111'];

		} else {
			return view('login.login');
		}
	}

	/***
    * 退出登录
    *
    ***/
	public function outLogin()
	{
		Session()->flush();
		return redirect('/login');
	}

}
