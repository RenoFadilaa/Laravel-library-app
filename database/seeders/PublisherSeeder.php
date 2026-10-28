<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PublisherSeeder extends Seeder
{
    public function run()
    {
        DB::table('publishers')->insert([
            [
                'publisher_id' => Str::uuid(),
                'publisher_name' => 'Gramedia',
                'publisher_description' => 'Penerbit Nasional'
            ],
            [
                'publisher_id' => Str::uuid(),
                'publisher_name' => 'Erlangga',
                'publisher_description' => 'Buku Pendidikan'
            ],
        ]);
    }
}