<?php

namespace App\Http\Controller;

use App\Provider\Request;

class CabinetController extends BaseController
{
    public function execute(Request $request)
    {
        echo '
            <form action="?action=pay" method="post">
                <input type="text" placeholder="Pay" name="cost"/> 
                <button>Pay</button>
            </form>
        ';
    }
}