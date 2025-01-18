<?php

declare(strict_types=1);

namespace BeastBytes\Router\Routes\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class Override implements RouteAttributeInterface
{
}