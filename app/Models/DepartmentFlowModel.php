<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentFlowModel extends Model
{
    protected $table = "department_flow";
    protected $guarded    = [];
    public    $timestamps = false;  //不采用时间戳
}
