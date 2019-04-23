<?php 

/***子集部门找主部门****/
function getPrentDepartment($id)
{
    $rs = DB::table('department')->where('id',$id)->first();
    return $rs->name;
}


//根据id找到最顶级部门
function getPrentDepartmentID($id)
{
    $one    = DB::table('department')->where('id',$id)->first();
    $two    = DB::table('department')->where('id',$one->pid)->first();
    $rs     = DB::table('department')->where('id',$two->pid)->first();
    if ($rs == null) {
       return $two;
    } else {
        return $rs;
    }
}


/******通过宿舍ID找到该公寓******/
function getDormitory($g_id,$f_id)
{
    $g_res = DB::table('apartment')->where('id',$g_id)->first();
    $f_res = DB::table('apartment')->where('id',$f_id)->first();
    return $g_res->name ."=>".$f_res->name;
}



 ?>