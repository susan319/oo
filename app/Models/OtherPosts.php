<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherPosts extends Model
{
    protected $table = "other_posts";
    protected $guarded    = [];
    public    $timestamps = false;  //不采用时间戳
}
