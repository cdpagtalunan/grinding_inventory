<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tbl_user_access', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('rapidx_id')->unsigned();
            $table->bigInteger('access_id')->unsigned();
            $table->bigInteger('logdel')->default(0)->comment = "0-active, 1-deleted";
            $table->timestamps();

            
            // $table->foreign('rapidx_id')->references('id')->on('users');
            $table->foreign('access_id')->references('id')->on('tbl_user_level');
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
