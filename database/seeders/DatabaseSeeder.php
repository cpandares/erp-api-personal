<?php

namespace Database\Seeders;

use App\Models\BancosSaldo;
use App\Models\EnterpriseType;
use App\Models\Taxes;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();

         EnterpriseType::factory()
            ->count(10)
            ->create();

        Taxes::factory()
            ->count(10)
            ->create();

        BancosSaldo::factory()
            ->count(30)
            ->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // password
            'email_verified_at' => now(),
            'username' => 'testuser',
        ]); */
    }
}
