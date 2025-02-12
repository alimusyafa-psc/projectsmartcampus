<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('mysql_third')->table('admin')->insert([
            'nama' => 'admin1',
            'email' => 'alimusyafa.2711@gmail.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
