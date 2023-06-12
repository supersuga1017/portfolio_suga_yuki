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
        Schema::create('gyoumu', function (Blueprint $table) {
            $table->string('id',10)->primary();; 
            $table->string('name')->unique();
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
        Schema::dropIfExists('gyoumu');
    }
};
