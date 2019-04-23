<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRateModel extends Model
{
    protected $table = "exchange_rate";
    protected $guarded    = [];
    public    $timestamps = false;  //不采用时间戳
}
