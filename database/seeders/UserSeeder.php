<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // default user
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@maus.com';
        $user->password = bcrypt('admin123');
        $user->save();
    }
}
