<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('non_delivery', function (Blueprint $table) {
            $table->id();
            $table->datetime('date');

            $table->string('gyoumu_cd');
            $table->foreign('gyoumu_cd')->references('id')->on('gyoumu');


            $table->unsignedBigInteger('return_reason_cd');
            $table->foreign('return_reason_cd')->references('id')->on('return_reason');

            $table->unsignedBigInteger('number');


            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_delivery');
    }
};
