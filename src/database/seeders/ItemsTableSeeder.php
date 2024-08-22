<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '2',
            'category_id' => '1',
            'condition_id' => '3',
            'name' => 'ハンドバッグ',
            'brand' =>'COACH',
            'description' => 'COACHのアウトレットで購入したcoachのハンドバックです。数回使用しましたが、目立った傷や汚れはないです。',
            'price' => '15000',
            'image_path' => 'バック画像.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => '2',
            'category_id' => '10',
            'condition_id' => '4',
            'name' => '家電3点セット',
            'brand' =>'',
            'description' => '電子レンジ、冷蔵庫、洗濯機の3点セットです。1年ちょっと使用しました。多少の傷や汚れはありますが、使用は問題なくできます。',
            'price' => '35000',
            'image_path' => '家電画像.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => '2',
            'category_id' => '15',
            'condition_id' => '1',
            'name' => '食品セット',
            'brand' =>'',
            'description' => '食品21点セットです。すべて新品で未開封です。賞味期限も1ヶ月はあります。家で食べきれないため、出品します。',
            'price' => '2500',
            'image_path' => '食品画像.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => '3',
            'category_id' => '1',
            'condition_id' => '2',
            'name' => 'ジャケット',
            'brand' =>'BEAMS',
            'description' => 'BEAMSで購入したジャケットです。サイズが合わなかったため、1回しか着用していません。自宅保管なので、気になる方は購入をお控えください。',
            'price' => '5500',
            'image_path' => '服画像.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => '3',
            'category_id' => '6',
            'condition_id' => '4',
            'name' => '鬼滅の刃全巻セット',
            'brand' =>'',
            'description' => '鬼滅の刃の全巻セットです。中古ではなく、すべて新品で購入しました。自宅保管なのでやや傷や汚れはあります。',
            'price' => '6800',
            'image_path' => '本画像.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('items')->insert($param);
    }
}
