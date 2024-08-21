<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Study>
 */
class StudyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'npm' => fake()->randomNumber(9, true),
            'nama' => fake()->name(),
            'prodi' => fake()->jobTitle(),
            'kode_mk' => fake()->numerify('MK_####'),
            'nama_mk' => fake()->words(2, true),
            'sks' => fake()->numberBetween(1, 4),
            'huruf' => fake()->randomLetter(),
            'tahun' => fake()->year(),
            'fakultas' => fake()->jobTitle(),
        ];
    }
}
