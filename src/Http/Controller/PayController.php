<?php

namespace App\Http\Controller;

use App\Provider\Request;

class PayController extends BaseController
{
    public function execute(Request $request)
    {
        $сost = $request->getQueryParameter('cost');

        header('/');

        // exit($сost);
    }
}