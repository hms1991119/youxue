<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminLoginLog extends Model
{
    //
    protected $fillable = [
        'last_login_ip', 'username', 'remark'
    ];
}
