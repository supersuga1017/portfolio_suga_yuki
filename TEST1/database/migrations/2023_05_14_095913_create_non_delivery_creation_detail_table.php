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
        Schema::create('non_delivery_creation_detail', function (Blueprint $table) {
            $table->id();

            $table->datetime('date');

            $table->unsignedBigInteger('kubun_cd');
            $table->foreign('kubun_cd')->references('id')->on('kubun');


            $table->string('gyoumu_cd');
            $table->foreign('gyoumu_cd')->references('id')->on('gyoumu');

            
            $table->integer('number'); // 件数
            $table->boolean('syogo_flag')->default(false); // 照合完了フラグ

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_delivery_creation_detail');
    }
};
