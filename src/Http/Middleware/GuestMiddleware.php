<?php

namespace App\Http\Middleware;

use App\Provider\Request;

class GuestMiddleware implements MiddlewareInterface
{
    public function handle(Request $request)
    {
        if($request->getAuth()) {
            throw new MiddlewareException('This page for guest');
        }
    }
}