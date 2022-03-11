<?php

namespace App\Http\Domain;

class UserDto
{
    public function __construct(
        public int $id
    )
    {
    }
}