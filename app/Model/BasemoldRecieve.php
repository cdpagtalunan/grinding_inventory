<?php

namespace App\Model;

use App\Model\Basemold;

use App\Model\BasemoldReceiveQr;
use Illuminate\Database\Eloquent\Model;

class BasemoldRecieve extends Model
{
    //
    protected $table = 'tbl_basemold_recieve';
    protected $connection = 'mysql';

    public function basemold(){
        return $this->hasOne(Basemold::class, 'id', 'fk_basemold_id');
    }

    public function basemold_qr(){
        return $this->hasOne(BasemoldReceiveQr::class,  'basemold_receive_id', 'id');
    }
}
