<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminAccount extends Model
{
    //
    protected $table = 'admin_accounts';

    protected $fillable = [
        'username', 'password', 'realname', 'api_token','role','phone','last_login_time','enabled'
    ];
}
