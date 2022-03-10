<?php

namespace App\Http\Middleware;

use App\Provider\Request;

interface MiddlewareInterface
{
    public function handle(Request $request);
}