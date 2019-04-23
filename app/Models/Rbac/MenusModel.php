<?php

namespace App\Models\Rbac;

use Illuminate\Database\Eloquent\Model;

class MenusModel extends Model
{
    protected $table = "rbac_menu";
    protected $guarded    = []; 
    public    $timestamps = false;  //不采用时间戳


    public function myAdd($request) 
    {
        #1 接受所有参数
        $data = $request->except('_token');
        
        #2 数据验证
        if ( $error = $this->checkValidate($data) ) 
            return ['code' => 0, 'msg' => $error];

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
        
        #2 数据验证
        if ( $error = $this->checkValidate($data,$id) ) 
            return ['code' => 0, 'msg' => $error];
    
        #3 数据修改
        if ( self::where('id',$id)->update($data) !== false ) 
            return ['code' => 1, 'msg' => '修改成功'];
        else 
            return ['code' => 0, 'msg' => '修改失败'];
    }


    public function myDelete($id)
    {   
       
    	$datas = self::where(['pid'=>$id,'status'=>1])->get();
        
        if ( count($datas) >= 1) 
            return ['code' => 0, 'msg' => '该菜单还有子菜单'];
   
        if ( self::where('id',$id)->delete() ) 
            return ['code' => 1, 'msg' => '删除成功！'];
        else 
            return ['code' => 0, 'msg' => '删除失败！'];
    }





    /*******表单验证*******/
    protected function checkValidate($data,$id = null)
    {
        $messages = [
            'name.between' => '菜单名2-10位',
        ];
        $role = [
            'name' => ['between:2,10'],  
        ];
        $validator = \Validator::make($data, $role, $messages);
        if ($validator->fails()) {
            $error_msg = $validator->errors()->first();
            return $error_msg;
        }
        return false;
    }


    /***
    * 无限极菜单
    *
    ****/
    public function getTree()
    {
        //查询所有数据
        $data  = self::orderBy('order','desc')->get(); 
        return $this->_reSort($data);
    }

    private function _reSort($data, $cat_pid=0, $isClear=TRUE)
    {   
        static $ret = array();
        if($isClear)
            $ret = array();

        foreach ($data as $k => $v)
        {
            if($v['pid'] == $cat_pid)
            {
                $ret[] = $v;
                $this->_reSort($data, $v['id'], FALSE);
            }
        }
        return $ret;
    }


    /***
    * 获取子菜单
    *
    ****/
    public function getChildren($id)
    {
        $data  = self::orderBy('order','desc')->where('status',1)->get();  
        return $this->_children($data, $id);
    }
    

    private function _children($data, $cat_pid=0, $isClear=TRUE)
    {   
        static $ret = array();
        if($isClear)
            $ret = array();
        foreach ($data as $k => $v)
        {
            if($v['pid'] == $cat_pid && $v['level'] <= 3)
            {
                $ret[] = $v;
                $this->_children($data, $v['id'], FALSE);
            }
        }
        return $ret;
    }







}
