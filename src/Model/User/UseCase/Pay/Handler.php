<?php

namespace App\Model\User\UseCase\Pay;

use App\Database\DbConnection;
use App\Model\User\Entity\UserRepository;

class Handler
{
    public function handle(Command $command)
    {
        $this->wrapIntoTransact(function () use ($command) {
            $user = (new UserRepository())->getById($command->userId);

            if ($user->getBalance() < $command->cost) {
                throw new \DomainException('Please, top up balance');
            }

            $this->pay($command->userId, $user->getBalance(), $command->cost);
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

    private function wrapIntoTransact(callable $cb)
    {
        $connection = (new DbConnection())->getConnection();
        $connection->beginTransaction();
        $cb();
        $connection->commit();
    }
}