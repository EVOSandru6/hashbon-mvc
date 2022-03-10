<?php

namespace App\Http\Controller;

use App\Provider\Request;

class CabinetController extends BaseController
{
    public function execute(Request $request)
    {
        $userName = $request->getUser()->username;
        $userBalance = $request->getUser()->balance;

        echo 'User: '. $userName . '<form action="?action=logout" method="post">
                <button>Logout</button>
            </form>
             
            <br><br> Balance: ' . $userBalance .'$ <br/><br/> 
            <form action="?action=pay" method="post">
                <input type="number" placeholder="Pay" name="cost" value="10" min="10" style="width:150px"/> 
                <button>Pay</button>
            </form>
        ';
    }
}