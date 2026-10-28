<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'firstname' => 'Reno',
                'lastname' => 'Fadila',
                'username' => 'reno',
                'email' => 'renoFadila@gmail.com',
                'password' => Hash::make('12345678'),
                'isadmin' => true
            ],
            [
                'id' => Str::uuid(),
                'firstname' => 'Restu',
                'lastname' => 'Galih',
                'username' => 'restu',
                'email' => 'RestuGalih@gmail.com',
                'password' => Hash::make('12345678'),
                'isadmin' => false
            ]
        ]);
    }
}
