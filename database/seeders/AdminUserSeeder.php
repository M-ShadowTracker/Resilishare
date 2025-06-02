<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
{
    \App\Models\User::create([
        'name' => 'Admin User',
        'email' => 'Smodd99@gmail.com',
        'password' => bcrypt('Mysite1896!'),
        'is_admin' => true
    ]);
}
}
