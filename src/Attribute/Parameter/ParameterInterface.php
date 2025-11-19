<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute\Parameter;

Interface ParameterInterface {
    public function getName(): string;
    public function getPattern(): string;
}