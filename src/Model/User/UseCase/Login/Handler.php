<?php

namespace App\Model\User\UseCase\Login;

use App\Http\Domain\UserDto;
use App\Model\User\Entity\UserRepository;

class Handler
{
    public function handle(Command $command)
    {
        $user = (new UserRepository)->getByIdentity($command->username, $command->password);

        if (!$user) {
            throw new \DomainException('User not found. Access denied.');
        }

        $sessionUser = new UserDto(id: $user->getId());

        session_start();
        $_SESSION['auth']['user'] = json_encode($sessionUser);
        session_write_close();
    }
}