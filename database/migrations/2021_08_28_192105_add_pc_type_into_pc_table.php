<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPcTypeIntoPcTable extends Migration
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
            $table->integer('pc_type')->after('hdd')->comment('1 = Normal Pc , 2 = Legacy Pc , 3 = workstation PC ')->nullable();

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
            $table->dropColumn('pc_type');
        });
    }
}
