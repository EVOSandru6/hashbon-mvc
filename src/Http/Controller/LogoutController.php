<?php

namespace App\Http\Controller;

use App\Http\Redirect;
use App\Provider\Request;
use JetBrains\PhpStorm\NoReturn;

class LogoutController extends BaseController
{
    #[NoReturn] public function execute(Request $request)
    {
        $this->checkCsrfValidOrFail(
            _csrf: $request->getFromBody('_csrf')
        );

        session_start();
        unset($_SESSION['auth']);
        session_write_close();

        $this->refreshCSRF();

        (new Redirect("Logout. Good luck!"))->execute();
    }
}