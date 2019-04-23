<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionPerformance extends Model
{
    protected $table = "promotion_performance";
    protected $guarded    = [];
    public    $timestamps = false;  //不采用时间戳
}
