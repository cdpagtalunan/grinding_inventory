<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Basemold;

class BasemoldWip extends Model
{
    //
    protected $table = 'tbl_wip_basemold';
    protected $connection = 'mysql';

    public function basemold(){
        return $this->hasOne(Basemold::class, 'id', 'fk_basemold_id');
    }
    
}
