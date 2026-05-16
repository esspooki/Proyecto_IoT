<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * Lista de URIs que deberían ser accesibles incluso durante el modo de mantenimiento.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
