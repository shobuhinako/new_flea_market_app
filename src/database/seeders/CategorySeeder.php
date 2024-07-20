<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'ファッション',
            'ベビー・キッズ',
            'ゲーム・おもちゃ・グッズ',
            'ホビー・楽器・アート',
            'チケット',
            '本・雑誌・漫画',
            'CD・DVD・ブルーレイ',
            'スマホ・タブレット・パソコン',
            'テレビ・オーディオ・カメラ',
            '生活家電・空調',
            'スポーツ',
            'アウトドア・釣り・旅行用品',
            'コスメ・美容',
            'ダイエット・健康',
            '食品・飲料・酒',
            'キッチン・日用品・その他',
            '家具・インテリア',
            'ペット用品',
            'DIY・工具',
            'フラワー・ガーデニング',
            'ハンドメイド・手芸',
            '車・バイク・自転車'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
