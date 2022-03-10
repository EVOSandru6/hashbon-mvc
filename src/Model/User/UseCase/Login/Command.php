<?php

namespace App\Model\User\UseCase\Login;

class Command
{
    public function __construct(
        public string $username,
        public string $password
    )
    {
        $minStrLen = 5;
        if(strlen($username) < $minStrLen) {
            throw new \DomainException("username is shorter, than $minStrLen");
        }

        if(strlen($password) < $minStrLen) {
            throw new \DomainException("password is shorter, than $minStrLen");
        }
    }
}