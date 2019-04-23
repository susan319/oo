<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DormitoryModel extends Model
{
    	
    protected $table = "dormitory";
    protected $guarded    = [];
    public    $timestamps = false;  //不采用时间戳	


    /**关联员工表***/
    public function staff()
    {
    	return $this->hasOne('App\Models\StaffModel','number','number');
    }

}
