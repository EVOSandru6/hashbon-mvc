<?php

namespace App\Http\Controller;

use App\Http\Redirect;
use App\Provider\Request;
use JetBrains\PhpStorm\NoReturn;

class LogoutController extends BaseController
{
    #[NoReturn] public function execute(Request $request)
    {
        session_start();
        unset($_SESSION['auth']);
        session_write_close();

        (new Redirect("Logout. Good luck!"))->execute();
    }
}