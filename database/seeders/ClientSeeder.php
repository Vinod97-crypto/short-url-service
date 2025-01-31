<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $superAdmin = User::where('role', 'super_admin')->first();

        
        if ($superAdmin) {
            $clients = [
                [
                    'name' => 'Client A',
                    'super_admin_id' => $superAdmin->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Client B',
                    'super_admin_id' => $superAdmin->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            
            Client::insert($clients);
        } else {
            
            $this->command->info('No super admin found. Client seeding skipped.');
        }
    }
}
