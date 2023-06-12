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
        Schema::create('label_gyoumu_detail', function (Blueprint $table) {
            $table->id();
            $table->datetime('non_delivery_date');
            // $table->foreign('non_delivery_date')->references('non_delivery_data')->on('label_print');

            $table->integer('label_manage_number');//ラベル番号

            $table->string('gyoumu_cd');
            $table->foreign('gyoumu_cd')->references('id')->on('gyoumu');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('label_gyoumu_detail');
    }
};
