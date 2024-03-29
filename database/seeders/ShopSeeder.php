<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shops')->insert([
            [
                'owner_id' => 1,
                'name' => 'おにぎりやさん',
                'information' => 'おにぎりグッズを販売しています。',
                'filename' => 'sample1.jpg',
                'is_selling' => true,
            ],
            [
                'owner_id' => 2,
                'name' => 'ここに店舗名が入ります',
                'information' => 'ここに店舗情報が入ります。ここに店舗情報が入ります。ここに店舗情報が入ります。',
                'filename' => 'sample2.jpg',
                'is_selling' => true,
            ],
        ]);
    }
}
