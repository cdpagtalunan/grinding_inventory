<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblWipBasemold extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('tbl_wip_basemold', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->BigInteger('fk_basemold_id')->unsigned();
            $table->string('PR_number')->nullable();
            $table->string('GR_number')->nullable();
            $table->string('remarks')->nullable();
            $table->bigInteger('IN')->default(0);
            $table->bigInteger('OUT')->default(0);
            $table->bigInteger('NG')->default(0);
            $table->bigInteger('golden_sample')->default(0);
            $table->bigInteger('EOH');
            // $table->string('remarks')->nullable();
            $table->bigInteger('logdel')->default(0)->comment = "0-active, 1-deleted";
            $table->string('accept_by')->nullable();
            $table->timestamps();


            $table->foreign('fk_basemold_id')->references('id')->on('tbl_basemold');

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
