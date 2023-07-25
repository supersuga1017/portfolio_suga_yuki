<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NonDelivery;
use App\Models\NonDeliveryDetail;
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
        for($i = 0; $i < 10; $i++) {
            NonDeliveryDetail::create([
                'non_delivery_cd' => 3, //文字列
                 'gyoumu_cd' => "JCB121" , //1〜2
                 'huutou_cd' => $faker->numberBetween(1, 999), //1〜999
                 'return_reasson_cd' => $faker->numberBetween(1, 10), //100〜5000
                 'date' => $faker->dateTime('now'), //現在までYmdHis
            ]);

         }
    }
}
