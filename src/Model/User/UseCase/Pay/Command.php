<?php

namespace App\Model\User\UseCase\Pay;

class Command
{
    public function __construct(
        public int   $userId,
        public float $cost,
    )
    {
        if($cost <= 0) {
            throw new \DomainException('Warning. Change your cost, please!');
        }
    }
}