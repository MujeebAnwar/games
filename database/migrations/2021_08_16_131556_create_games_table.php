<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('avg_pc_name')->nullable();
            $table->string('avg_pc_ram')->nullable();
            $table->string('avg_pc_processor')->nullable();
            $table->string('avg_pc_graphicCard')->nullable();
            $table->string('best_pc_name')->nullable();
            $table->string('best_pc_ram')->nullable();
            $table->string('best_pc_processor')->nullable();
            $table->string('best_pc_graphicCard')->nullable();
        
            $table->integer('sort_id');           
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
        Schema::dropIfExists('games');
    }
}
