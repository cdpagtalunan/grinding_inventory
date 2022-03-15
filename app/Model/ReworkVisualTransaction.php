<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReworkVisualTransaction extends Model
{
    //
    protected $table = "tbl_rework_visual_transaction";
    protected $connection = "mysql";


    public function rework_visual_info(){
        return $this->hasOne(ReworkVisual::class, 'id', 'fk_rework_id');
    }
}
