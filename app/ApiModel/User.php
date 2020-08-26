<?php

namespace App\ApiModel;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable=[
        'nickname','openid','session_key','access_token','avatar_url','gender','province',
        'city'
    ];
}
