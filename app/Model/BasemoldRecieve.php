<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\Basemold;

class BasemoldRecieve extends Model
{
    //
    protected $table = 'tbl_basemold_recieve';
    protected $connection = 'mysql';

    public function basemold(){
        return $this->hasOne(Basemold::class, 'id', 'fk_basemold_id');
    }
}
