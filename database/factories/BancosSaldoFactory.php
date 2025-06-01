<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BancosSaldo>
 */
class BancosSaldoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
    {
        $banks = [
            ['name' => 'Banesco', 'prefix' => '0134'],
            ['name' => 'Venezuela', 'prefix' => '0102'],
            ['name' => 'Provincial', 'prefix' => '0108'],
            ['name' => 'Caribe', 'prefix' => '0109'],
        ];

        $bank = $this->faker->randomElement($banks);
        $accountNumber = $bank['prefix'] . $this->faker->numerify(str_repeat('#', 16));

    
        return [
            'nombre_banco' => $bank['name'],
            'numero_cuenta' => $accountNumber,
            'saldo' => round($this->faker->randomFloat(2, 1000, 100000), 2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}


