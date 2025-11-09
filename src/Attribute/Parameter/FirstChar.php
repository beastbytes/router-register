<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

enum FirstChar
{
    case alpha;
    case alphaNumeric;
    case numeric;
}