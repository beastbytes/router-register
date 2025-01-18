<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;

/**
 * Define a host for all routes in class
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class Host implements ClassAttributeInterface
{
    public function __construct(
        private string $host
    )
    {
    }

    public function getHost(): string
    {
        return $this->host;
    }
}