<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NonDelivery;
use App\Models\NonDeliveryDetail;
use App\Models\Huutou;
use Faker\Factory as Faker;


class NondeliveryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create('ja_JP');

        $huutou_number = $faker->numberBetween(1, 20);//封筒の数を乱数で決定
        $huutou_number = 1;

        // 不着データを登録する
        NonDelivery::create([
             'date' => $faker->dateTime('now'), //現在までYmdHis
             'gyoumu_cd' => 'DEVI41', //1〜999
             'return_reasson_cd' => 3, //100〜5000
             'number' => $huutou_number, //現在までYmdHis
             'creation_flag' => 0, //現在までYmdHis
        ]);

        for($i = 0; $i < $huutou_number; $i++) { //封筒の数だけ繰り返し

            // 封筒データ
            Huutou::create([
                'kakitome_number' => $faker->numberBetween(1, 999), //文字列
                'manage_number' => $faker->numberBetween(1, 999),
                'huutou_qr_number' => $faker->numberBetween(1, 999), //1〜999
                'non_delivery_date' => $faker->dateTime('now'), //100〜5000
                'status_cd' => 1,
                'syogo_flag' => 0, 
            ]);

            // 不着明細データ
            NonDeliveryDetail::create([
                'date' => $faker->dateTime('now'), //現在までYmdHis
                'non_delivery_cd' => 28, //文字列
                'gyoumu_cd' => "JCB121" , //1〜2
                'huutou_cd' => 68,
                'return_reasson_cd' => $faker->numberBetween(1, 10), //100〜5000
            ]);

         }
    }
}
