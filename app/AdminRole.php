<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    //可赋值
    protected $fillable = [
        'name', 'enabled', 'power_str'
    ];
}
