<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Log;

class LogFactory extends Factory
{
    //Esta factory se utiliza para generar datos de prueba para el modelo Log, creando registros con valores aleatorios para el ID del sensor, tipo de evento, icono, mensaje y nivel de severidad.
    protected $model = Log::class;

    public function definition(): array
    {
        return [
            'sensor_id' => $this->faker->randomElement(['esp32-01', 'esp32-02', 'esp32-03']),
            'tipo' => $this->faker->randomElement(['comando', 'alerta', 'Administrador', 'Sistema']),
            'icono' => $this->faker->randomElement([
                'fa-fan',
                'fa-tint',
                'fa-bell',
                'fa-exclamation-triangle'
            ]),
            'mensaje' => $this->faker->sentence(),
            'nivel' => $this->faker->randomElement(['info', 'advertencia', 'error']),
        ];
    }
    public function comando()
    {
        return $this->state(fn () => [
            'sensor_id' => $this->faker->randomElement(['esp32-01', 'esp32-02', 'esp32-03']),
            'tipo' => 'comando',
            'icono' => 'fa-cog',
            'mensaje' => $this->faker->randomElement([
                'Ventilación activada automáticamente',
                'Ventilación desactivada automáticamente',
                'Ventilación activada manualmente',
                'Ventilación desactivada manualmente',
                'Riego automático activado',
                'Riego automático desactivado',
                'Riego manual activado',
                'Riego manual desactivado',

            ]),
            'nivel' => 'info'
        ]);
    }

    public function alerta()
    {
        return $this->state(fn () => [
            'tipo' => 'alerta',
            'mensaje' => $this->faker->randomElement([
                'Alerta por luz baja',
                'Alerta por luz alta',
                'Alerta por temperatura alta',
                'Alerta por temperatura baja',
                'Alerta por humedad alta',
                'Alerta por humedad baja',
            ]),
            'nivel' => $this->faker->randomElement(['advertencia', 'error'])
        ]);
    }
}
