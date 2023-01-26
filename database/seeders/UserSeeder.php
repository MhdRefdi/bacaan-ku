<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@bacaan-ku.com',
            'role' => 'admin',
            'password' => bcrypt(12341234),
        ]);
    }
}
