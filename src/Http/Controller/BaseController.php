<?php

namespace App\Http\Controller;

use App\Provider\Request;

abstract class BaseController
{
    abstract public function execute(Request $request);
}