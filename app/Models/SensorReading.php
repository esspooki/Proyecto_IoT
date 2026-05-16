<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SensorReading extends Model
{
    use HasFactory;
    protected $fillable = ['sensor_id', 'temperatura', 'humedad', 'luz', 'estado_riego', 'estado_luz', 'estado_ventilacion'];
}
