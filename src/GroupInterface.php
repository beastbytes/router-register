<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

interface GroupInterface
{
    public function getNamePrefix(): string;
    public function getPrefix(): string;
}