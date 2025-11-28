<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Attribute;

use Attribute;
use RuntimeException;

/**
 * Define the group prefix.
 *
 * The prefix can be defined as an array or a string.
 * string: the prefix.
 * array: prefix segments.
 *   If a segment key is an integer the value is a prefix segment.
 *   If a segment key is a string the key is a parameter name and the value the pattern.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_CLASS_CONSTANT)]
final class Prefix implements AttributeInterface
{
    public const FWD_SLASH = '/';

    /**
     * @param non-empty-array<int|string, string>|non-empty-string $prefix
     */
    public function __construct(private readonly array|string $prefix)
    {
    }

    public function getPrefix(): string
    {
        if (is_array($this->prefix)) {
            $prefix = [];

            foreach ($this->prefix as $parameter => $pattern) {
                $prefix[] = is_int($parameter) ? $pattern : sprintf('{%s:%s}', $parameter, $pattern);
            }

            $prefix = implode(self::FWD_SLASH, $prefix);
        } else {
            $prefix = $this->prefix;
        }

        return (str_starts_with($prefix, self::FWD_SLASH) ? '' : self::FWD_SLASH) . $prefix;
    }
}