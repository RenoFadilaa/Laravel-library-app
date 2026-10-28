<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        DB::table('authors')->insert([
            [
                'author_id' => Str::uuid(),
                'author_name' => 'Andrea Hirata',
                'author_description' => 'Penulis Indonesia'
            ],
            [
                'author_id' => Str::uuid(),
                'author_name' => 'Tere Liye',
                'author_description' => 'Novel'
            ],
        ]);
    }
}