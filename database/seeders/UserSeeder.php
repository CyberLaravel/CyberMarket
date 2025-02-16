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
        // Create users with roles in a more concise way
        $roleMap = [
            'admin' => 5,
            'seller' => 15,
            'customer' => 30
        ];

        foreach ($roleMap as $role => $count) {
            User::factory($count)
                ->withPersonalTeam()
                ->create()
                ->each(fn($user) => $user->assignRole($role));
        }
    }
}
