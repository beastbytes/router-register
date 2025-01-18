<?php

declare(strict_types=1);

namespace BeastBytes\Router\Routes;

trait RouteTrait
{
    public function getName(): string
    {
        return $this->name;
    }
    public function getUri(): string
    {
        return $this->value;
    }
}