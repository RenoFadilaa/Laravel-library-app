<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ShelfSeeder extends Seeder
{
    public function run()
    {
        DB::table('shelfs')->insert([
            [
                'shelf_id' => Str::uuid(),
                'shelf_name' => 'Rak A',
                'shelf_position' => 'Lantai 1'
            ],
            [
                'shelf_id' => Str::uuid(),
                'shelf_name' => 'Rak B',
                'shelf_position' => 'Lantai 2'
            ]
        ]);
    }
}