<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Guide;

class GuideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'guide_number' => $this->faker->text(10),
            'shipping_date' => $this->faker->date('Y-m-d', 'now'),
            'country_origin' => $this->faker->country(),
            'sender_name' => $this->faker->name(),
            'sender_address' => $this->faker->address(),
            'sender_phone' => $this->faker->phoneNumber(),
            'sender_email' => $this->faker->email(),
            'destination_country' => $this->faker->country(),
            'recipient_name' => $this->faker->name(),
            'recipient_address' => $this->faker->address(),
            'recipient_phone' => $this->faker->phoneNumber(),
            'recipient_email' => $this->faker->email(),
            'total' => $this->faker->randomFloat(2),
        ];
    }
}
