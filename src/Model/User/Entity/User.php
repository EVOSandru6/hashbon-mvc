<?php

namespace App\Model\User\Entity;

class User
{
    public function __construct(
        private int    $id,
        private string $username,
        private float  $balance
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }
}