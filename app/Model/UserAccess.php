<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\RapidxLogin;
use App\Model\UserLevel;


class UserAccess extends Model
{
    //
    protected $table = "tbl_user_access";
    protected $connection = "mysql";

    public function rapid_login(){
        return $this->hasOne(RapidxLogin::class, 'id', 'rapidx_id');
    } 
    public function user_level(){
        return $this->hasOne(UserLevel::class, 'id', 'access_id');
    }
}
