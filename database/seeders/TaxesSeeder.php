<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Taxes::factory(10)->create([
            'name' => 'Tax ' . rand(1, 100),
            'description' => 'Description for tax ' . rand(1, 100),
            'percentage' => rand(0, 100),
            'is_active' => rand(0, 1),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
