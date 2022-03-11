<?php

namespace App\Provider;

use App\Http\Domain\UserAuthDto;
use App\Http\Middleware\MiddlewareInterface;

class Request
{
    public function __construct(
        private array $parameters,
        private array $body,
        private array $headers,
        private array $session,
    )
    {
    }

    public function getQueryParameter($key)
    {
        return $this->parameters[$key] ?? throw new \DomainException('Query parameter not found');
    }

    public function getFromBody($key)
    {
        return $this->body[$key] ?? throw new \DomainException('Body parameter not found');
    }

    public function getFromHeader($key)
    {
        return $this->headers[$key] ?? throw new \DomainException('Header not found');
    }

    public function getAuth(): ?array
    {
        return $this->session['auth'] ?? null;
    }

    public function getUser(): UserAuthDto
    {
        $user = json_decode($this->getAuth()['user']);

        return new UserAuthDto(id: $user->id);
    }

    public function addMiddleware(MiddlewareInterface $middleware): static
    {
        try {
            $middleware->handle($this);
            return $this;
        } catch (\Exception $e) {
            throw new \DomainException("Middleware failed {$e->getMessage()}");
        }
    }

    public function isPostMethod(): bool
    {
        return strtolower($this->headers['REQUEST_METHOD']) === 'post';
    }

    public function isGetMethod(): bool
    {
        return strtolower($this->headers['REQUEST_METHOD']) === 'get';
    }
}