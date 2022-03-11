<?php

namespace App\Model\User\UseCase\Pay;

use App\Database\DbConnection;
use App\Model\User\Entity\User;
use App\Model\User\Entity\UserRepository;

class Handler
{
    public function handle(Command $command)
    {
        session_write_close();

        $this->wrapIntoTransact(function () use ($command) {
            $dbUser = $this->getUser($command->userId);
            if ($dbUser->getBalance() < $command->cost) {
                throw new \DomainException('Please, top up balance');
            }
            $this->pay($command->userId, $dbUser->getBalance(), $command->cost);
        });
    }

    private function pay(int $userId, int $balance, int $cost)
    {
        $newVal = $balance - $cost;

        $connection = (new DbConnection())->getConnection();
        $stmt = $connection->prepare("update users set balance = '$newVal' where id=?");
        $stmt->execute([$userId]);
        $stmt->fetch();

        $errorInfo = $stmt->errorInfo();

        if (!!$errorInfo[1]) {
            throw new \DomainException('Pay failed: ' . json_encode($errorInfo));
        }
    }

    public function getUser(int $id): User
    {
        return (new UserRepository())->getById($id);
    }

    private function wrapIntoTransact(callable $cb)
    {
        $connection = (new DbConnection())->getConnection();
        $cb();
        $connection->commit();
    }
}