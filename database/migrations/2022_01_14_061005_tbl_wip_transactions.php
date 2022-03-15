<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblWipTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tbl_wip_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fk_basemold_recieve_id')->nullable()->unsigned()->comment = "fk from tbl_basemold_recieve";
            $table->bigInteger('fk_basemold_id')->nullable()->unsigned()->comment = "fk from tbl_wip_basemold";
            $table->bigInteger('fk_rework_visual_id')->nullable()->unsigned()->comment = "fk from tbl_rework_visual";
            $table->bigInteger('fk_fgs_recieve_id')->nullable()->unsigned()->comment = "fk from tbl_fgs_recieve";
            $table->string('transaction_date');
            $table->string('remarks')->nullable();
            $table->bigInteger('logdel')->default(0)->comment = "0-active, 1-deleted";
            $table->timestamps();

            
            $table->foreign('fk_basemold_recieve_id')->references('id')->on('tbl_basemold_recieve');
            $table->foreign('fk_basemold_id')->references('id')->on('tbl_wip_basemold');
            $table->foreign('fk_rework_visual_id')->references('id')->on('tbl_rework_visual');
            $table->foreign('fk_fgs_recieve_id')->references('id')->on('tbl_fgs_recieve');


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
