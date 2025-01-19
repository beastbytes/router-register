<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

enum AlphaCase
{
    case insensitive;
    case lower;
    case upper;
}