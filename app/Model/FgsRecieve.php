<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use App\Model\FGS;


class FgsRecieve extends Model
{
    protected $table = "tbl_fgs_recieve";
    protected $connection = "mysql";

    public function fgs_details(){
        return $this->hasOne(FGS::class, 'id', 'fk_fgs_id');
    }
}
