<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InvitationSeeder extends Seeder
{
    public function run(): void
    {
        Invitation::insert([
            [
                'email' => 'user1@gmail.com',
                'client_id' => 1, 
                'role' => 'admin',
                'expires_at' => Carbon::now()->addDays(7),
                'token' => Str::random(32),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user2@gmail.com',
                'client_id' => 2,
                'role' => 'member',
                'expires_at' => Carbon::now()->addDays(7),
                'token' => Str::random(32),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'user3@gmail.com',
                'client_id' => 1,
                'role' => 'member',
                'expires_at' => Carbon::now()->addDays(7),
                'token' => Str::random(32),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

