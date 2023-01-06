<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 10. recibiendo datos del cliente API
        'http://localhost.apirest-laravel.com/registro',
        // 16. API RESTful Crear nuevo registro de curso en Laravel
        'http://localhost.apirest-laravel.com/curso',
        //17. API RESTful Editar un registro de curso en Laravel - el * es el id
        'http://localhost.apirest-laravel.com/curso/*',
    ];
}
