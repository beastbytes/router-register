<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Route;

interface GroupInterface
{
    public function getName(): string;
    public function getNamePrefix(): string;
    public function getRoutePrefix(): string;
}