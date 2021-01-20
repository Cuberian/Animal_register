<?php

namespace Database\Factories;

use App\Models\AnimalTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimalTraitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnimalTrait::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'size' => $this->faker->randomElement(['big','medium','small']),
        'category' => $this->faker->randomElement(['cat','dog']),
        'wool' => $this->faker->randomElement(['short_wool','long_wool', 'hard_wool', 'сurly_wool'])
        ];
    }
}
