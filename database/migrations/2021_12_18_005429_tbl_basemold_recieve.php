<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblBasemoldRecieve extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_basemold_recieve', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date');
            $table->BigInteger('fk_basemold_id')->unsigned();
            $table->string('pr_number')->nullable();
            $table->string('gr_number')->nullable();
            // $table->string('lot_no');
            $table->string('from');
            // $table->bigInteger('no_of_items');
            // $table->bigInteger('qty_basemold');
            $table->bigInteger('qty_confirmed');
            // $table->bigInteger('qty_after_grinding');
            $table->string('remarks')->nullable();
            $table->bigInteger('status')->default(0)->comment = "0-Not Check, 1-Checked, 3-w/Remarks";
            $table->bigInteger('logdel')->default(0)->comment = "0-active, 1-deleted";
            $table->string('created_by')->nullable();
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
