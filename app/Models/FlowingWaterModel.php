<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlowingWaterModel extends Model
{
    protected $table = "flowing_water";
    protected $guarded    = [];
    public    $timestamps = false;  //不采用时间戳
}
