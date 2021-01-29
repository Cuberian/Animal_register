<?php

namespace Database\Factories;

use App\Models\AnimalTrait;
use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Card::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'animal_name' => $this->faker->name,
            'gender' => $this->faker->boolean,
            'date_birth' => $this->faker->date(),
            'identify_mark' => $this->faker->randomDigit,
            'chip_number' => $this->faker->randomDigit,
            'owner_signs' => "ошейник, шлейка",
            'animal_signs' => "острые коготочки",
            'animal_traits_id' => AnimalTrait::factory()->create()->id,
            'municipality' => $this->faker->text,
            'place' => $this->faker->text,
            'picture' => "",
            'scan_frame' => "",
            'sterilisation_date' => $this->faker->date(),
            'vaccination_date' => $this->faker->date(),
            'current_status' => $this->faker->boolean,
            'publicity_status' => $this->faker->boolean,
            'change_status_date' => $this->faker->date(),
        ];
    }
}
