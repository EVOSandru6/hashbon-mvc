<?php

namespace App\Model\User\Entity;

use App\Database\DbConnection;

class UserRepository
{
    public function getById(int $id): User
    {
        $connection = (new DbConnection())->getConnection();
        $stmt = $connection->prepare("SELECT id, username, balance FROM users where id=?");
        $stmt->execute([$id]);
        $rawUser = $stmt->fetch();

        if (!$rawUser) {
            throw new \DomainException('User not found');
        }

        return new User(
            id: $rawUser['id'],
            username: $rawUser['username'],
            balance: $rawUser['balance']
        );
    }

    public function getByIdentity(string $username, string $password): ?User
    {
        $connection = (new DbConnection())->getConnection();

        $stmt = $connection->prepare("SELECT id, username, balance FROM users where username=? and password=?");
        $stmt->execute([$username, md5($password)]);
        $rawUser = $stmt->fetch();

        if (!$rawUser) {
            throw new \DomainException('Access denied');
        }

        return new User(
            id: $rawUser['id'],
            username: $rawUser['username'],
            balance: $rawUser['balance']
        );
    }
}