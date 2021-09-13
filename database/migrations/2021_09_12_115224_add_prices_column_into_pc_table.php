<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricesColumnIntoPcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pcs', function (Blueprint $table) {
            //
        
            $table->float('ram_price',8,2)->default(0);
            $table->float('ssd_price',8,2)->default(0);
            $table->float('hdd_price',8,2)->default(0);
            $table->float('ps_price',8,2)->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pcs', function (Blueprint $table) {
            //
            $table->dropColumn(['ram_price','ssd_price','hdd_price','ps_price']);
        });
    }
}
