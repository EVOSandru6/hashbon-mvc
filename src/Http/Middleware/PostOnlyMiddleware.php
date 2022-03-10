<?php

namespace App\Http\Middleware;

use App\Provider\Request;

class PostOnlyMiddleware implements MiddlewareInterface
{
    public function handle(Request $request)
    {
        if(!$request->isPostMethod()) {
            throw new MiddlewareException('Request must be POST type');
        }
    }
}