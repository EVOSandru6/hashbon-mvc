<?php

namespace App\Model\User\UseCase\Pay;

use App\Database\DbConnection;
use App\Http\Domain\UserDto;

class Handler
{
    public function handle(Command $command)
    {
        session_write_close();

        $dbUser = $this->getUser($command->userId);

        if ($dbUser->balance < $command->cost) {
            throw new \DomainException('Please, top up balance');
        }

        $this->pay($command->userId, $dbUser->balance, $command->cost);

        $dbUser = $this->getUser($command->userId);

        session_start();
        $_SESSION['auth']['user'] = json_encode($dbUser);
        session_write_close();
    }

    public function getUser(int $userId): UserDto
    {
        $connection = (new DbConnection())->getConnection();
        $stmt = $connection->prepare("SELECT id, username, balance FROM users where id=?");
        $stmt->execute([$userId]);
        $rawUser = $stmt->fetch();

        if (!$rawUser) {
            throw new \DomainException('User not found');
        }

        return new UserDto(
            id: $rawUser['id'],
            username: $rawUser['username'],
            balance: $rawUser['balance']
        );
    }

    private function pay(int $userId, int $balance, int $cost)
    {
        $newVal = $balance - $cost;

        $connection = (new DbConnection())->getConnection();
        $connection->beginTransaction();
        $stmt = $connection->prepare("update users set balance = '$newVal' where id=?");

        // var_dump($stmt->queryString);

        $stmt->execute([$userId]);
        $stmt->fetch();
        $connection->commit();

        $errorInfo = $stmt->errorInfo();

        if (!!$errorInfo[1]) {
            throw new \DomainException('Pay failed');
        }
    }
}