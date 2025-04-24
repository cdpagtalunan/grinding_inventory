<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BasemoldQrRemarksList extends Model
{
    protected $table = 'basemold_qr_remarks_lists';
    protected $connection = 'mysql';

    protected $fillable = [
        'remarks',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
