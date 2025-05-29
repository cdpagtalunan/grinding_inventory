<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReworkQrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rework_qrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rework_id');
            $table->bigInteger('po_qty');
            $table->string('rw_lot_no');
            $table->string('rw_sat')->nullable();
            $table->string('sel_remarks');
            $table->string('rw_gold_sample')->nullable();
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
        Schema::dropIfExists('rework_qrs');
    }
}
