<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Lista de excepciones que no se reportarán.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * Lista de entradas que no se incluirán en los mensajes de error para la validación de excepciones.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registra los manejadores de excepciones para la aplicación.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
