<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\FGS;

class ReworkVisual extends Model
{
    //

    protected $table = "tbl_rework_visual";
    protected $connection = "mysql";

    public function fgs_details(){
        return $this->hasOne(FGS::class, 'id', 'fk_fgs_id');
    }
}
