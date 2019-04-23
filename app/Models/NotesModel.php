<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotesModel extends Model
{
    protected $table = "mynotes";
    protected $guarded    = [];
    public    $timestamps = false;  //不采用时间戳


    public function myAdd($data)
    {
        $rs = self::create($data);
        return $rs->id;
    }



}
