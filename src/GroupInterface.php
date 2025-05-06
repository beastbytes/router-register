<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register;

interface GroupInterface
{
    public function getName(): string;
    public function getPrefix(): string;
    public function getNamePrefix(): string;
}