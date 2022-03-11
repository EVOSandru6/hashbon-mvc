<?php

namespace App\Http;

class CSRF
{
    public function refresh()
    {
        session_start();
        $_SESSION['_csrf'] = md5(uniqid(mt_rand(), true));
        session_write_close();
    }

    public function invoke()
    {
        return $_SESSION['_csrf'];
    }
}