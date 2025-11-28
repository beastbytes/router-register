<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

use BeastBytes\Router\Register\Attribute\DefaultValue;
use BeastBytes\Router\Register\Attribute\Fallback;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\MiddlewareInterface;
use BeastBytes\Router\Register\Attribute\Override;
use BeastBytes\Router\Register\Attribute\Parameter\Pattern;
use BeastBytes\Router\Register\Attribute\Route;
use ReflectionMethod;

final class MethodAttributes
{
    use AttributesTrait;

    public function __construct(private readonly ReflectionMethod $reflector)
    {
    }

    /** @return list<DefaultValue> */
    public function getDefaultValues(): array
    {
        return $this->getAttributes(DefaultValue::class);
    }

    public function getFallback(): ?Fallback
    {
        return $this->getAttribute(Fallback::class);
    }

    /** @return list<Host> */
    public function getHosts(): array
    {
        return $this->getAttributes(Host::class);
    }

    /** @return list<MiddlewareInterface> */
    public function getMiddlewares(): array
    {
        return $this->getAttributes(MiddlewareInterface::class);
    }

    public function getOverride(): ?Override
    {
        return $this->getAttribute(Override::class);
    }

    /** @return list<Pattern> */
    public function getParameters(): array
    {
        return $this->getAttributes(Pattern::class);
    }

    public function getRoute(): ?Route
    {
        return $this->getAttribute(Route::class);
    }
}