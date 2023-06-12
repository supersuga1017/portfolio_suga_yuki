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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->datetime('date');//指示日

            // 封筒CD
            $table->unsignedBigInteger('non_delivery_detail_cd')->unsigned();
            $table->foreign('non_delivery_detail_cd')->references('id')->on('non_delivery_detail');

            // 状態　未登録とか廃棄済みとかとか
            $table->unsignedBigInteger('status_cd')->unsigned();
            $table->foreign('status_cd')->references('id')->on('statuses');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
