<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.未完成！！！！
     */

    //  未完成！！！！
    public function up(): void
    {
        Schema::create('picking_list_output_detail', function (Blueprint $table) {
            $table->id();

            // 指示登録日
            $table->datetime('registration_date');

            // 廃棄BOX No
            $table->integer('haiki_number')->unsigned();

            // 封筒CD
            $table->unsignedBigInteger('huutous_cd')->unsigned();
            $table->foreign('huutous_cd')->references('id')->on('huutous');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('picking_list_output_detail');
    }
};
