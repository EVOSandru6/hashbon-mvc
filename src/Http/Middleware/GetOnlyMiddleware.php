<?php

namespace App\Http\Middleware;

use App\Provider\Request;

class GetOnlyMiddleware implements MiddlewareInterface
{
    public function handle(Request $request)
    {
        if (!$request->isGetMethod()) {
            throw new MiddlewareException('Request must be GET type');
        }
    }
}