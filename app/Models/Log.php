<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    //Modelo para representar los logs de eventos en el sistema, con campos para el ID del sensor, tipo de evento, mensaje del evento, nivel de severidad y fecha del evento.
    use HasFactory;
    protected $fillable = [
        'sensor_id',
        'tipo',
        'icono',
        'mensaje',
        'nivel',
    ];
}
