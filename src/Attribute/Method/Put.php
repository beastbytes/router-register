<?php

declare(strict_types=1);

namespace BeastBytes\Router\Routes\Attribute\Method;

use BeastBytes\Router\Routes\Attribute\Route;
use BeastBytes\Router\Routes\RouteInterface;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class Put extends Route
{
    public function __construct(
        RouteInterface $route,
        array|callable|string $middleware = [],
        array|callable|string $disableMiddleware = [],
    )
    {
        parent::__construct(
            methods: [Method::PUT],
            route: $route,
            middleware: $middleware,
            disableMiddleware: $disableMiddleware
        );
    }
}