<?php

namespace App\Models\Rbac;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    
    protected $table = "rbac_role";
    protected $guarded    = []; 
    public    $timestamps = false;  //不采用时间戳



    public function myAdd ($request) 
    {
    	#1 接受所有参数
    	$data = $request->except('_token');
    	
    	#3 数据添加
    	if ( self::create($data) ) 
    		return ['code' => 1, 'msg' => '添加成功'];
    	else 
    		return ['code' => 0, 'msg' => '添加失败'];
    }



    public function myEdit ($request, $id) 
    {
    	#1 接受所有参数
    	$data =  $request->except('_token','_method');
    	
    	#3 数据修改
    	if ( self::where('id',$id)->update($data) !== false ) 
    		return ['code' => 1, 'msg' => '修改成功'];
    	else 
    		return ['code' => 0, 'msg' => '修改失败'];
    }


}
