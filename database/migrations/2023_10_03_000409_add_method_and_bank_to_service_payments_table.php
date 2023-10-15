<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_payments', function (Blueprint $table) {
            $table->enum('method', ['Cash', 'Transfer'])->default('Cash')->after('total_fee');
            $table->foreignId('id_bank')->nullable()->after('method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_payments', function (Blueprint $table) {
            //
        });
    }
};
