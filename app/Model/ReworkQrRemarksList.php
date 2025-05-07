<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReworkQrRemarksList extends Model
{
    protected $table = 'rework_qr_remarks_lists';
    protected $connection = 'mysql';

    protected $fillable = [
        'remarks',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
