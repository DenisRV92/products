<?php

namespace Database\Seeders;

use DateInterval;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insertOrIgnore([
            [
                'article' => 'mtokb2',
                'name' => 'MTOK-B2/216-1KT3645-K',
                'status' => 'available',
                'data' => json_encode([
                    'Цвет' => 'черный',
                    'Размер' => 'L'
                ]),
            ],
            [
                'article' => 'mtokb3',
                'name' => 'MTOK-B3/216-1KT3645-K',
                'status' => 'unavailable',
                'data' => json_encode([
                    'Цвет' => 'серый',
                    'Размер' => 'XL'
                ]),
            ],
        ], 'article');
    }
}
