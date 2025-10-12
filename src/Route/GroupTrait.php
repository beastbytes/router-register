<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Route;

trait GroupTrait
{
    public function getName(): string
    {
        return $this->name;
    }

    public function getNamePrefix(): string
    {
        return $this->name . (defined(self::class . '::SEPARATOR') ? self::class::SEPARATOR : '.');
    }

    public function getRoutePrefix(): string
    {
        $commonPrefixes = $this->commonPrefixes();

        return (sizeof($commonPrefixes) > 0 ? '/' . implode('/', $commonPrefixes) : '')
            . (mb_strlen($this->value) > 0 ? '/' . $this->value : '')
        ;
    }

    private function commonPrefixes(): array
    {
        $prefixes = [];

        if (defined(self::class . '::PREFIX')) {
            foreach (self::class::PREFIX as $parameter => $pattern) {
                $prefixes[] = is_int($parameter) ? $pattern : sprintf('{%s:%s}', $parameter, $pattern);
            }
        }

        return $prefixes;
    }
}