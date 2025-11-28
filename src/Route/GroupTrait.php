<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Route;

use BeastBytes\Router\Register\Attribute\Prefix;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionEnumBackedCase;

trait GroupTrait
{
    /** @internal */
    public function getPrefix(): ?string
    {
        $prefix = [$this->value];

        $reflectionClass = new ReflectionClass($this);

        $prefixes = $reflectionClass->getAttributes(Prefix::class, ReflectionAttribute::IS_INSTANCEOF);

        if (sizeof($prefixes) > 0) {
            $prefix[] = $prefixes[0]->newInstance()->getPrefix();
        }

        $prefix = implode(array_reverse($prefix));

        return mb_strlen($prefix) > 0 ? $prefix : null;
    }
}