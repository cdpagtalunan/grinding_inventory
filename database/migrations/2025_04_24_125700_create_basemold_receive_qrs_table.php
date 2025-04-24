<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasemoldReceiveQrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basemold_receive_qrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('basemold_receive_id');
            $table->bigInteger('po_qty');
            $table->string('bm_lot_no');
            $table->string('bm_sat');
            $table->string('sel_remarks');
            $table->string('bm_gold_sample');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('basemold_receive_qrs');
    }
}
