<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = $this->faker->randomElement([0, 1, 2, 3]);
        $nameArray = [
            'Eat breakfast',
            'Eat lunch',
            'Eat dinner',
            'Go to bed on time',
            'Play cellphone',
            'Running',
            'Aerobic exercise',
        ];
        $scoreArray = [100, 300, 100, 50, 200, 50, 50];
        $randomNumber = $this->faker->numberBetween(0, 6);
        $startTime = $this->faker->dateTimeBetween('-1 months');

        return [
            'status' => $status,
            'name' => $nameArray[$randomNumber],
            'start_time' => $startTime,
            'end_time' => $this->faker->dateTimeBetween($startTime),
            'score' => $scoreArray[$randomNumber],
        ];
    }

    public function status()
    {
        return $this->state(function (array $attributes) {
            if ($attributes['status'] == 2 || $attributes['status'] == 3) {
                return [
                    'end_time' => null,
                ];
            }

            return [];
        });
    }
}
