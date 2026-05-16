<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SensorReading extends Model
{
    //Modelo para representar las lecturas de los sensores, con campos para el ID del sensor, temperatura, humedad, luz, estado del riego, estado de la luz y estado de la ventilación.
    use HasFactory;
    protected $fillable = ['sensor_id', 'temperatura', 'humedad', 'luz', 'estado_riego', 'estado_luz', 'estado_ventilacion'];
}
