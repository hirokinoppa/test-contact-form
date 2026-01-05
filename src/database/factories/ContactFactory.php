<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 4),
            'first_name'  => $this->faker->firstName(),
            'last_name'   => $this->faker->lastName(),
            'gender'      => $this->faker->numberBetween(1, 2),
            'email'       => $this->faker->unique()->safeEmail(),
            'tel'         => $this->faker->numerify('090########'),
            'address'     => $this->faker->address(),
            'building'    => $this->faker->optional()->word(),
            'detail'      => $this->faker->text(),
        ];
    }
}
