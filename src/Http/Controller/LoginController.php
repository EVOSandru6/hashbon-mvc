<?php

namespace App\Http\Controller;

use App\Http\Redirect;
use App\Model\User\UseCase\Login\Command as LoginCommand;
use App\Model\User\UseCase\Login\Handler as LoginHandler;
use App\Provider\Request;

class LoginController extends BaseController
{
    public function execute(Request $request)
    {
        try {
            $this->checkCsrfValidOrFail(
                _csrf: $request->getFromBody('_csrf')
            );

            $cmd = new LoginCommand(
                username: $request->getFromBody('username'),
                password: $request->getFromBody('password')
            );

            (new LoginHandler())->handle($cmd);

            $this->refreshCSRF();

            (new Redirect('Login success!'))->execute();
        } catch (\Exception $e) {
            (new Redirect("error: {$e->getMessage()}"))->execute();
        }
    }
}