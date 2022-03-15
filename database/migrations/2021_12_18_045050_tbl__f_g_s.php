<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblFGS extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_fgs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fgs_code');
            $table->string('fgs_name');
            $table->bigInteger('logdel')->default(0)->comment = "0-active, 1-deleted";
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
