<?php

namespace App\Model\User\UseCase\Pay;

use App\Database\DbConnection;
use App\Http\Domain\UserDto;

class Handler
{
    public function handle(Command $command)
    {
        $dbUser = $this->getUser($command->userId);

        if($dbUser->balance < $command->cost) {
            throw new \DomainException('Please, top up balance');
        }

        $this->pay($command->userId, $command->cost);

        $dbUser = $this->getUser($command->userId);

        $_SESSION['auth']['user'] = json_encode($dbUser);
    }

    public function getUser(int $userId): UserDto
    {
        $connection = (new DbConnection())->getConnection();
        $stmt = $connection->prepare("SELECT id, username, balance FROM users where id=?");
        $stmt->execute([$userId]);
        $rawUser = $stmt->fetch();

        if(!$rawUser) {
            throw new \DomainException('User not found');
        }

        return new UserDto(
            id: $rawUser['id'],
            username: $rawUser['username'],
            balance: $rawUser['balance']
        );
    }

    private function pay(int $userId, int $cost)
    {

        $connection = (new DbConnection())->getConnection();
        $connection->beginTransaction();
        $stmt = $connection->prepare("update users set balance = balance - '$cost' where id=?");
        $stmt->execute([$userId]);
        $stmt->fetch();
        $connection->rollBack();

        $errorInfo = $stmt->errorInfo();

        if(!!$errorInfo[1]) {
            throw new \DomainException('Pay failed');
        }
    }
}