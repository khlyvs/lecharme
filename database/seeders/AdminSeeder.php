<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      

        Admin::create([
            'name' => 'Ssaddsaa',
            'email' => 'admin2@admin.com',
            'password' => Hash::make('123456'),
            'status' => 1,
        ]);
    }
}
