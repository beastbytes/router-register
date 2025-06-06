<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

trait RouteTrait
{
    public function getName(?string $prefix = null, ?GroupInterface $group = null): string
    {
        $name = $group instanceof GroupInterface ? $group->getNamePrefix() : '';
        $name .= $prefix !== null ? $prefix . '_' : '';
        return $name . $this->name;
    }

    public function getUri(): string
    {
        return $this->value;
    }
}