<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests\resources\Middleware;

class MethodLevelMiddleware
{
    public function withParameter(string $parameter): self
    {
        return $this;
    }
}