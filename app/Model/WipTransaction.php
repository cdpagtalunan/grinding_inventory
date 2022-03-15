<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\BasemoldRecieve;
use App\Model\FgsRecieve;
use App\Model\BasemoldWip;
use App\Model\ReworkVisual;

class WipTransaction extends Model
{
    //
    protected $table = "tbl_wip_transactions";
    protected $connection = "mysql";

    public function basemold_recieve(){
        return $this->hasOne(BasemoldRecieve::class, 'id', 'fk_basemold_recieve_id');
    }
    public function fgs_recieve(){
        return $this->hasOne(FgsRecieve::class, 'id', 'fk_fgs_recieve_id');
    }
    public function basemold_wip(){
        return $this->hasOne(BasemoldWip::class, 'id', 'fk_basemold_id');
    }
    public function rework_visual(){
        return $this->hasOne(ReworkVisual::class, 'id', 'fk_rework_visual_id');
    }
    
}
