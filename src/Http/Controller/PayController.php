<?php

namespace App\Http\Controller;

use App\Http\Redirect;
use App\Model\User\UseCase\Pay\Command as PayCommand;
use App\Model\User\UseCase\Pay\Handler as PayHandler;
use App\Provider\Request;

class PayController extends BaseController
{
    public function execute(Request $request)
    {
        try {
            $cost = $request->getFromBody('cost');

            $cmd = new PayCommand(
                userId: $request->getUser()->id,
                cost: $cost
            );

            (new PayHandler)->handle($cmd);

            (new Redirect("Pay released!"))->execute();
        } catch (\Exception $e) {
            (new Redirect("Pay failed: " . $e->getMessage()))->execute();
        }
    }
}