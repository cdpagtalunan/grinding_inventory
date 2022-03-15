<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblReworkVisual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tbl_rework_visual', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fk_fgs_id')->unsigned();
            $table->string('PR_number')->nullable();
            $table->string('GR_number')->nullable();
            $table->bigInteger('fgs_rework_IN')->default(0);
            $table->bigInteger('fgs_rework_OUT')->default(0);
            $table->bigInteger('fgs_rework_NG')->default(0);
            $table->bigInteger('fgs_visuak_NG')->default(0);
            $table->bigInteger('EOH')->default(0);
            $table->string('remarks')->nullable();
            $table->bigInteger('logdel')->default(0)->comment = "0-active, 1-deleted";
            $table->timestamps();

            $table->foreign('fk_fgs_id')->references('id')->on('tbl_fgs');

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
