<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Calling each individual seeder to seed the respective tables

        
        $this->call(UserSeeder::class);

        
        $this->call(ClientSeeder::class);

       
        $this->call(UrlSeeder::class);

        
        $this->call(InvitationSeeder::class);
    }
}
