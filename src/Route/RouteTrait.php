<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Route;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\Prefix;
use ReflectionAttribute;
use ReflectionClass;

trait RouteTrait
{
    private const HOISTED_ROUTE = '//';

    /**
     * Allow getting the route name by calling the route enumeration case.
     * example: Route::index() returns the route name for the `index` case of the `Route` enumeration
     */
    public static function __callStatic(string $name, array $arguments): string
    {
        return self::{$name}->getRouteName();
    }

    /**
     * @internal
     */
    public function getPrefix(): ?string
    {
        $reflectionClass = new ReflectionClass($this);
        $prefixes = $reflectionClass->getAttributes(Prefix::class, ReflectionAttribute::IS_INSTANCEOF);
        return sizeof($prefixes) > 0 ? $prefixes[0]->newInstance()->getPrefix() : null;
    }

    public function getRouteName(): string
    {
        $name = [$this->name];

        $reflectionClass = new ReflectionClass($this);
        $attributes = $reflectionClass->getAttributes(Group::class, ReflectionAttribute::IS_INSTANCEOF);

        if (sizeof($attributes) > 0) {
            /** @var Group $attribute */
            $attribute = $attributes[0]->newInstance();
            $name[] = $attribute->getName();

            if ($attribute->hasParent()) {
                $name[] = $attribute->getParent()->name;
            }
        }

        return implode('.', array_reverse($name));
    }

    /**
     * @internal
     */
    public function isHoisted(): bool
    {
        return str_starts_with($this->value, self::HOISTED_ROUTE);
    }
}