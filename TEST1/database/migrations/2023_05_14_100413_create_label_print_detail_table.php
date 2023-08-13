<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //  未完成！！！！


    public function up(): void
    {
        Schema::create('label_print_detail', function (Blueprint $table) {
            $table->id();
            $table->datetime('non_delivery_data');

            $table->integer('print_number')->unsigned();

            $table->string('gyoumu_cd');
            $table->foreign('gyoumu_cd')->references('id')->on('gyoumu');

            $table->boolean('used_flag')->default(false);

            // $table->unsignedBigInteger('gyoumu_id_cd');
            // $table->foreign('gyoumu_id_cd')->references('id')->on('gyoumu_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('label_print_detail');
    }
};
