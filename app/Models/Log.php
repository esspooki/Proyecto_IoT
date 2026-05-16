<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;
    protected $fillable = [
        'sensor_id',
        'tipo',
        'icono',
        'mensaje',
        'nivel',
    ];
}
