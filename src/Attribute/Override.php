<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class Override implements AttributeInterface
{
}