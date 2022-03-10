<?php

namespace App\Model\User\UseCase\Pay;

class Command
{
    public function __construct(
        public int $userId,
        public int $cost,
    )
    {
    }
}