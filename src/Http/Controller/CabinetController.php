<?php

namespace App\Http\Controller;

use App\Http\CSRF;
use App\Model\User\Entity\UserRepository;
use App\Provider\Request;

class CabinetController extends BaseController
{
    public function execute(Request $request)
    {
        $this->refreshCSRF();

        $user = (new UserRepository)->getById($request->getUser()->id);

        echo 'User: ' . $user->getUsername() . '<form action="?action=logout" method="post">
                <input type="hidden" name="_csrf" value="' . $this->invokeCsrf() . '">
                <button>Logout</button>
            </form>
             
            <br><br> Balance: ' . $user->getBalance() . '$ <br/><br/> 
            
            <form action="?action=pay" method="post">
                <input type="hidden" name="_csrf" value="' . $this->invokeCsrf() . '">
                <input type="number" placeholder="Pay" name="cost" value="10" min="10" style="width:150px"/> 
                <button>Pay</button>
            </form>
        ';
    }
}