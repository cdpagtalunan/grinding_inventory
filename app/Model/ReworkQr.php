<?php

namespace App\Model;

use App\Model\BasemoldRecieve;
use Illuminate\Database\Eloquent\Model;

class ReworkQr extends Model
{
    protected $table = "rework_qrs";
    protected $connection = "mysql";

    // public function basemold_receive_details(){
    //     return $this->hasOne(BasemoldRecieve::class, 'id', 'basemold_receive_id');
    // }
}
