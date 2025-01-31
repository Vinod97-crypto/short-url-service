<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Url;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Str;

class UrlSeeder extends Seeder
{
    public function run()
    {
        $client = Client::first();  
        $user = User::first();      

       
        if ($client && $user) {
            $urls = [
                [
                    'long_url' => 'https://google.com',
                    'short_url' => Str::random(6),
                    'client_id' => $client->id,
                    'user_id' => $user->id,
					'hits' => 10,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'long_url' => 'https://fb.com',
                    'short_url' => Str::random(6),
                    'client_id' => $client->id,
                    'user_id' => $user->id,
					'hits' => 80,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];            
            Url::insert($urls);
        } else {
            $this->command->info('No client or user found. URL seeding skipped.');
        }
    }
}
