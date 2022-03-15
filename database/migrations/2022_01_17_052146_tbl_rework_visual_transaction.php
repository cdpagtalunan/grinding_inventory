<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblReworkVisualTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tbl_rework_visual_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('date');
            $table->bigInteger('fk_rework_id')->unsigned();
            $table->String('remarks')->nullable();
            $table->bigInteger('status')->default(0)->comment = "0-active,1-serve";
            $table->bigInteger('logdel')->default(0)->comment = "0-active,1-deleted";
            $table->timestamps();

            
            $table->foreign('fk_rework_id')->references('id')->on('tbl_rework_visual');
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
