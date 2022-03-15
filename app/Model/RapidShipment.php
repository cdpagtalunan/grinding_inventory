<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RapidShipment extends Model
{
    //

    protected $table = "tbl_PreShipmentTransaction";
    protected $connection = "mysql_rapid";
}
