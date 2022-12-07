<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSpvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nama' => 'Spv '.Str::random(3),
            'email' => Str::random(3).'.fanspv@mailinator.com',
            'npp' => rand(1000,9999),
            'password' => Hash::make('1111'),
            'created_at' => Carbon::now()
        ]);
    }
}
