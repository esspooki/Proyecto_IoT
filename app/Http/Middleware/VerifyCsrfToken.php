<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Lista de URIs que deberían ser excluidas de la verificación CSRF.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
