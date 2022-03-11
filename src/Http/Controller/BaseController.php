<?php

namespace App\Http\Controller;

use App\Http\CSRF;
use App\Provider\Request;
use JetBrains\PhpStorm\Pure;

abstract class BaseController
{
    abstract public function execute(Request $request);

    protected function refreshCSRF()
    {
        (new CSRF)->refresh();
    }

    #[Pure] protected function invokeCsrf()
    {
        return (new CSRF)->invoke();
    }

    public function checkCsrfValidOrFail(string $_csrf): void
    {
        $sessionCsrf = (new CSRF)->invoke();

        if ($sessionCsrf !== $_csrf) {
            throw new \DomainException('CSRF invalid');
        }
    }
}