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
        $users = User::factory(5)->create();
        foreach ($users as $user) {
            $user->assignRole('admin');
        }

        $users = User::factory(15)->create();
        foreach ($users as $user) {
            $user->assignRole('seller');
        }

        $users = User::factory(30)->create();
        foreach ($users as $user) {
            $user->assignRole('customer');
        }
    }
}
