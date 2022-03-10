<?php

namespace App\Model\User\Entity;

class User
{
    public function __construct(
        private string $name,
        private int $balance
    )
    {
    }

    public function getPath(): string
    {
        return __CLASS__ .':'.__FILE__;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }
}