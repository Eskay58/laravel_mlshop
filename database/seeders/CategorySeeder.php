<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('primary_categories')->insert([
            [
                'name' => 'ファッション',
                'sort_order' => 1,
            ],
            [
                'name' => 'バッグ',
                'sort_order' => 2,
            ],
            [
                'name' => '生活雑貨',
                'sort_order' => 3,
            ],
        ]);

        DB::table('secondary_categories')->insert([
            [
                'name' => 'Tシャツ',
                'sort_order' => 1,
                'primary_category_id' => 1,
            ],
            [
                'name' => 'パンツ',
                'sort_order' => 2,
                'primary_category_id' => 1,
            ],
            [
                'name' => 'アウター',
                'sort_order' => 3,
                'primary_category_id' => 1,
            ],
            [
                'name' => 'トートバッグ',
                'sort_order' => 1,
                'primary_category_id' => 2,
            ],
            [
                'name' => 'リュック',
                'sort_order' => 2,
                'primary_category_id' => 2,
            ],
            [
                'name' => 'サコッシュ',
                'sort_order' => 3,
                'primary_category_id' => 2,
            ],
            [
                'name' => 'タンブラー',
                'sort_order' => 1,
                'primary_category_id' => 3,
            ],
            [
                'name' => 'ハンカチ',
                'sort_order' => 2,
                'primary_category_id' => 3,
            ],
            [
                'name' => 'キーホルダー',
                'sort_order' => 3,
                'primary_category_id' => 3,
            ],
            [
                'name' => 'クッション',
                'sort_order' => 4,
                'primary_category_id' => 3,
            ],
        ]);
    }
}
