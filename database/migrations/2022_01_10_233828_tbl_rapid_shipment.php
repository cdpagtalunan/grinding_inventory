<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblRapidShipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tbl_rapid_shipment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rapid_id');
            $table->string('PONo');
            $table->string('Partscode');
            $table->string('DeviceName');
            $table->string('Qty');
            $table->string('logdel')->comment = "0-active, 1-delete";
            $table->string('LastUpdate');
            $table->bigInteger('rapid_status')->default(0)->comment = "0-pending, 1-confirm";
            $table->timestamps();
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
