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
            $username = $request->getFromBody('username');
            $password = $request->getFromBody('password');

            $cmd = new LoginCommand($username, $password);

            $user = (new LoginHandler())->handle($cmd);

            if($user) {
                (new Redirect('Login success!'))->execute();
            }

            throw new \DomainException('Access denied.');
        } catch (\Exception $e){
            (new Redirect("error: {$e->getMessage()}"))->execute();
        }
    }
}