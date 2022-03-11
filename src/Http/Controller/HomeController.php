<?php

namespace App\Http\Controller;

use App\Provider\Request;

class HomeController extends BaseController
{
    public function execute(Request $request)
    {
        $this->refreshCSRF();

        echo '
            <form action="?action=login" method="post">
                <input type="hidden" name="_csrf" value="' . $this->invokeCsrf() . '">
                <input type="text" name="username"/> 
                <input type="password" name="password"/> 
                <button>Login</button>
            </form>
        ';
    }
}