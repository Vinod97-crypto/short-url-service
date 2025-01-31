<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
       
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'client_id' => 1,
                'signup_status' => true,
                'email_token' => Str::random(32),
                'email_token_expiry' => Carbon::now()->addHours(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'client_id' => 1, 
                'signup_status' => true,
                'email_token' => Str::random(32),
                'email_token_expiry' => Carbon::now()->addHours(2),
                'created_at' => now(),
                'updated_at' => now(),
            ], 
             [
                'name' => 'Member User',
                'email' => 'member@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'member',
                'client_id' => 1, 
                'signup_status' => true,
                'email_token' => Str::random(32),
                'email_token_expiry' => Carbon::now()->addHours(2),
                'created_at' => now(),
                'updated_at' => now(),
            ], 			
        ];
        
        User::insert($users);
    }
}
