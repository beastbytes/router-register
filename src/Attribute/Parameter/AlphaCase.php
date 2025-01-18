<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

enum AlphaCase
{
    case Insensitive;
    case Lower;
    case Upper;
}