<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('mother_board')->nullable();
            $table->string('processor')->nullable();
            $table->string('ram')->nullable();
            $table->string('graphic_card')->nullable();
            $table->string('power_supply')->nullable();
            $table->string('casing')->nullable();
            $table->string('ssd')->nullable();
            $table->string('hdd')->nullable();
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
        Schema::dropIfExists('pcs');
    }
}
