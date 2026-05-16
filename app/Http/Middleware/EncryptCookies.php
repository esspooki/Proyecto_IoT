<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * Lista de cookies que no serán encriptadas.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
