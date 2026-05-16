<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Los proxies que se deben confiar, puede ser un array de IPs o el valor '*' para confiar en todos los proxies.
     *
     * @var array|string|null
     */
    protected $proxies;

    /**
     * Los encabezados que se deben usar para detectar proxies confiables, por defecto se usan los encabezados estándar de Laravel para proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
