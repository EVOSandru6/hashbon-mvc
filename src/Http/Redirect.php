<?php

namespace App\Http;

use JetBrains\PhpStorm\NoReturn;

class Redirect
{
    public function __construct(
        private string $message
    )
    {
    }

    #[NoReturn] public function execute()
    {
        echo $this->message;
        header("refresh:2;url=/");
        exit();
    }
}