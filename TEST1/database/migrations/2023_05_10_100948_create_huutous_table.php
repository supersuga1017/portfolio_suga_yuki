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
        Schema::create('huutous', function (Blueprint $table) {
            $table->id();
            // 書留番号 11桁数字のみ
            $table->integer('kakitome_number')->length(11)->unsigned();

            // 管理番号 英文字含み、17桁
            $table->string('manage_number', 50);

            // 封筒QR
            $table->integer('huutou_qr_number')->unsigned();

            // 不着登録日
            $table->datetime('non_delivery_date');

            // 状態　未登録とか廃棄済みとかとか
            $table->unsignedBigInteger('status_cd')->unsigned();
            $table->foreign('status_cd')->references('id')->on('statuses');

            // 照合フラグ OK or 未
            $table->boolean('syogo_flag')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('huutous');
    }
};
