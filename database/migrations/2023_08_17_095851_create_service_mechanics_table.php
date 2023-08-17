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
        Schema::create('service_mechanics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_service');
            $table->foreignId('id_mechanic');
            $table->timestamps();

            $table->foreign('id_service')->references('id')->on('services');
            $table->foreign('id_mechanic')->references('id')->on('mechanicals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_mechanics');
    }
};
