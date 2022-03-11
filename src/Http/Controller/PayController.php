<?php

namespace App\Http\Controller;

use App\Http\CSRF;
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
            $_csrf = $request->getFromBody('_csrf');

            $this->checkCsrfValidOrFail($_csrf);

            $cmd = new PayCommand(
                userId: $request->getUser()->id,
                cost: $cost
            );

            (new PayHandler)->handle($cmd);

            (new CSRF)->refresh();

            (new Redirect("Pay released!"))->execute();
        } catch (\Exception $e) {
            (new Redirect("Pay failed: " . $e->getMessage()))->execute();
        }
    }

    public function checkCsrfValidOrFail(string $_csrf): void
    {
        $sessionCsrf = (new CSRF)->invoke();

        if ($sessionCsrf !== $_csrf) {
            throw new \DomainException('CSRF invalid');
        }
    }
}