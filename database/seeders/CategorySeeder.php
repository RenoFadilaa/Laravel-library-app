<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            [
                'category_id' => Str::uuid(),
                'category_name' => 'Novel',
                'category_description' => 'Novel Indonesia'
            ],
            [
                'category_id' => Str::uuid(),
                'category_name' => 'Komputer',
                'category_description' => 'Pemrograman'
            ]
        ]);
    }
}