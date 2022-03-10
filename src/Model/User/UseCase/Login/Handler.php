<?php

namespace App\Model\User\UseCase\Login;

use App\Database\DbConnection;
use App\Http\Domain\UserDto;

class Handler
{
    public function handle(Command $command): ?UserDto
    {
        $connection = (new DbConnection())->getConnection();

        $stmt = $connection->prepare("SELECT id, username, balance FROM users where username=? and password=?");
        $stmt->execute([$command->username, md5($command->password)]);
        $rawUser = $stmt->fetch();

        if (!$rawUser) {
            throw new \DomainException('User not found');
        }

        $user = new UserDto(
            id: $rawUser['id'],
            username: $rawUser['username'],
            balance: $rawUser['balance']
        );

        $_SESSION['auth']['user'] = json_encode($user);

        return $user;
    }
}