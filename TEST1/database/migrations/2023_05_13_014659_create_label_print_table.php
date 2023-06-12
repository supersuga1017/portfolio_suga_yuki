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
        Schema::create('label_print', function (Blueprint $table) {
            $table->id();
            $table->datetime('non_delivery_data');
            $table->integer('all_number');
            $table->tinyInteger('customer_cd');
            $table->foreign('customer_cd')->references('id')->on('customer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('label_print');
    }
};
