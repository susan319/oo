<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryStructureModel extends Model
{
    
    protected $table = "salary_structure";
    protected $guarded    = [];
    public    $timestamps = false;  //不采用时间戳




    public function myAdd ($request)
    {
        #1 接受所有参数
        $data =  $request->except('_token');

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
    



    /*****Tree****/
    public function getTree()
    {
        //查询所有数据
        $data  = self::get();
        return $this->_reSort($data);
    }

    private function _reSort($data, $cat_pid=0, $level=0, $isClear=TRUE)
    {
        static $ret = array();
        if($isClear)
            $ret = array();

        foreach ($data as $k => $v)
        {
            if($v['pid'] == $cat_pid)
            {
                $v['level'] = $level;

                $ret[] = $v;
                $this->_reSort($data, $v['id'], $level+1, FALSE);
            }
        }
        return $ret;
    }
    /*****Tree****/

}
