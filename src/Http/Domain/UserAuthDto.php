<?php

namespace App\Http\Domain;

class UserAuthDto
{
    public function __construct(
        public int $id
    )
    {
    }
}