<?php

declare(strict_types=1);

namespace BeastBytes\Router\Routes\Attribute\Parameter;

enum AlphaCase
{
    case Insensitive;
    case Lower;
    case Upper;
}