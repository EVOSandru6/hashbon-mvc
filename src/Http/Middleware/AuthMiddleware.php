<?php

namespace App\Http\Middleware;

use App\Provider\Request;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request)
    {
        if (!$request->getAuth()) {
            throw new MiddlewareException('Unauthorized');
        }
    }
}