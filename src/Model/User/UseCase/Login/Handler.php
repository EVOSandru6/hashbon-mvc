<?php

namespace App\Model\User\UseCase\Login;

use App\Database\DbConnection;
use App\Http\Domain\UserDto;

class Handler
{
    public function handle(Command $command): ?UserDto
    {
        $instance = new DbConnection();
        $connection = $instance->getConnection();

        $stmt = $connection->prepare("SELECT id, username, balance FROM users where username=? and password=?");
        $users = $stmt->execute([$command->username, md5($command->password)]);

        var_dump($users);
        exit();

        if(!$users) {
            throw new \DomainException('user not found');
        }

        return new UserDto(
            id: $users[0]['id'],
            username: $users[0]['username'],
            balance: $users[0]['balance']
        );
    }
}