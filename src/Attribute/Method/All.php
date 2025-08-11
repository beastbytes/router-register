<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Method;

use BeastBytes\Router\Register\Attribute\Route;
use BeastBytes\Router\Register\RouteInterface;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class All extends Route
{
    public function __construct(RouteInterface $route)
    {
        parent::__construct(
            [
                Method::DELETE,
                Method::GET,
                Method::HEAD,
                Method::OPTIONS,
                Method::PATCH,
                Method::POST,
                Method::PUT,
            ],
            $route
        );
    }
}