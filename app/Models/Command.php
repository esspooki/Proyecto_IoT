<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Command extends Model
{
    //Modelo para representar los comandos enviados a los sensores, con campos para el ID del sensor, tipo de comando, valor del comando, estado del comando y fecha de ejecución.
    use HasFactory;
    protected $fillable = [
        'sensor_id',
        'tipo_comando',
        'valor_comando',
        'estado_comando',
        'fecha_ejecucion',
    ];

    protected $casts = [
        'valor_comando' => 'boolean',
        'fecha_ejecucion' => 'datetime',
    ];
}
