<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Method;

use Attribute;
use BeastBytes\Router\Register\Attribute\Route;
use BeastBytes\Router\Register\Route\RouteInterface;

#[Attribute(Attribute::TARGET_METHOD)]
final class Head extends Route
{
    public function __construct(RouteInterface $route)
    {
        parent::__construct([Method::HEAD], $route);
    }
}