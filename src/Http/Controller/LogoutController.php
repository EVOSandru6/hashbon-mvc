<?php

namespace App\Http\Controller;

use App\Http\Redirect;
use App\Provider\Request;
use JetBrains\PhpStorm\NoReturn;

class LogoutController extends BaseController
{
    #[NoReturn] public function execute(Request $request)
    {
        unset($_SESSION['user']);

        (new Redirect("Logout. Good luck!"))->execute();
    }
}