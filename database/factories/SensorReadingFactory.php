<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SensorReadingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sensor_id'   => $this->faker->randomElement(['esp32-01', 'esp32-02', 'esp32-03']),
            'temperatura' => $this->faker->randomFloat(1, 15.0, 40.0),
            'humedad'     => $this->faker->randomFloat(1, 30.0, 90.0),
            'luz'        => $this->faker->randomFloat(1, 0.0, 1000.0),
            'estado_riego' => $this->faker->boolean(),
            'estado_luz' => $this->faker->boolean(),
            'estado_ventilacion' => $this->faker->boolean(),
            'created_at'  => $this->faker->dateTimeBetween('-7 days', 'now'),
        ];
    }
}