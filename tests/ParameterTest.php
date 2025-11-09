<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Attribute\Parameter\Alpha;
use BeastBytes\Router\Register\Attribute\Parameter\AlphaCase;
use BeastBytes\Router\Register\Attribute\Parameter\Alphanumeric;
use BeastBytes\Router\Register\Attribute\Parameter\FirstChar;
use BeastBytes\Router\Register\Attribute\Parameter\Hex;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Parameter\In;
use BeastBytes\Router\Register\Attribute\Parameter\Numeric;
use BeastBytes\Router\Register\Attribute\Parameter\ParameterInterface;
use BeastBytes\Router\Register\Attribute\Parameter\Pattern;
use BeastBytes\Router\Register\Attribute\Parameter\Uuid;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yiisoft\Security\Random;

class ParameterTest extends TestCase
{
    #[Test]
    #[DataProvider('caseProvider')]
    public function alpha(string $name, AlphaCase $case): void
    {
        $alpha = match($case) {
            AlphaCase::insensitive => 'a-zA-Z',
            AlphaCase::lower => 'a-z',
            AlphaCase::upper => 'A-Z',
        };

        $patterns = [
            "[$alpha]+" => null,
            "[$alpha]{%s}" => 'int',
            "[$alpha]{,%s}" => 'max',
            "[$alpha]{%s,}" => 'min',
            "[$alpha]{%s,%s}" => 'range',
        ];

        foreach ($patterns as $patternTemplate => $lengthType) {
            $length = $this->getLength($lengthType);

            $pattern = match ($lengthType) {
                'int' => sprintf($patternTemplate, $length),
                'max' => sprintf($patternTemplate, $length['max']),
                'min' => sprintf($patternTemplate, $length['min']),
                'range' => sprintf($patternTemplate, $length['min'], $length['max']),
                default => $patternTemplate
            };

            $this->assertions(new Alpha(name: $name, length: $length, case: $case), $name, $pattern);
        }
    }

    #[Test]
    #[DataProvider('caseProvider')]
    public function alphaNumeric(string $name, AlphaCase $case): void
    {
        $alpha = match($case) {
            AlphaCase::insensitive => 'a-zA-Z',
            AlphaCase::lower => 'a-z',
            AlphaCase::upper => 'A-Z',
        };

        $patterns = [
            "[\d$alpha]+" => [null, FirstChar::alphaNumeric],
            "\d[\d$alpha]*" => [null, FirstChar::numeric],
            "[$alpha][\d$alpha]*" => [null, FirstChar::alpha],
            "[\d$alpha]{%s}" => ['int', FirstChar::alphaNumeric],
            "\d[\d$alpha]{%s}" => ['int', FirstChar::numeric],
            "[$alpha][\d$alpha]{%s}" => ['int', FirstChar::alpha],
            "[\d$alpha]{,%s}" => ['max', FirstChar::alphaNumeric],
            "\d[\d$alpha]{,%s}" => ['max', FirstChar::numeric],
            "[$alpha][\d$alpha]{,%s}" => ['max', FirstChar::alpha],
            "[\d$alpha]{%s,}" => ['min', FirstChar::alphaNumeric],
            "\d[\d$alpha]{%s,}" => ['min', FirstChar::numeric],
            "[$alpha][\d$alpha]{%s,}" => ['min', FirstChar::alpha],
            "[\d$alpha]{%s,%s}" => ['range', FirstChar::alphaNumeric],
            "\d[\d$alpha]{%s,%s}" => ['range', FirstChar::numeric],
            "[$alpha][\d$alpha]{%s,%s}" => ['range', FirstChar::alpha],
        ];

        foreach ($patterns as $patternTemplate => $config) {
            [$lengthType, $firstChar] = $config;

            $length = $this->getLength($lengthType);
            $lengthAdjust = $firstChar === FirstChar::alphaNumeric ? 0 : 1;

            $pattern = match ($lengthType) {
                'int' => sprintf($patternTemplate, $length - $lengthAdjust),
                'max' => sprintf($patternTemplate, $length['max'] - $lengthAdjust),
                'min' => sprintf($patternTemplate, $length['min'] - $lengthAdjust),
                'range' => sprintf(
                    $patternTemplate,
                    $length['min'] - $lengthAdjust,
                    $length['max'] - $lengthAdjust
                ),
                default => $patternTemplate
            };

            $this->assertions(
                new Alphanumeric(name: $name, length: $length, firstChar: $firstChar, case: $case),
                $name,
                $pattern
            );
        }
    }

    #[Test]
    #[DataProvider('caseProvider')]
    public function Hex(string $name, AlphaCase $case): void
    {
        $alpha = match($case) {
            AlphaCase::insensitive => 'a-fA-F',
            AlphaCase::lower => 'a-f',
            AlphaCase::upper => 'A-F',
        };

        $patterns = [
            "[\d$alpha]+" => [null, false],
            "[1-9$alpha][\d$alpha]*" => [null, true],
            "[\d$alpha]{%s}" => ['int', false],
            "[1-9$alpha][\d$alpha]{%s}" => ['int', true],
            "[\d$alpha]{,%s}" => ['max', false],
            "[1-9$alpha][\d$alpha]{,%s}" => ['max', true],
            "[\d$alpha]{%s,}" => ['min', false],
            "[1-9$alpha][\d$alpha]{%s,}" => ['min', true],
            "[\d$alpha]{%s,%s}" => ['range', false],
            "[1-9$alpha][\d$alpha]{%s,%s}" => ['range', true],
        ];

        foreach ($patterns as $patternTemplate => $config) {
            [$lengthType, $nonZero] = $config;

            $length = $this->getLength($lengthType);
            $lengthAdjust = $nonZero ? 1 : 0;

            $pattern = match ($lengthType) {
                'int' => sprintf($patternTemplate, $length - $lengthAdjust),
                'max' => sprintf($patternTemplate, $length['max'] - $lengthAdjust),
                'min' => sprintf($patternTemplate, $length['min'] - $lengthAdjust),
                'range' => sprintf(
                    $patternTemplate,
                    $length['min'] - $lengthAdjust,
                    $length['max'] - $lengthAdjust
                ),
                default => $patternTemplate
            };

            $this->assertions(new Hex(name: $name, length: $length, nonZero: $nonZero, case: $case), $name, $pattern);
        }
    }

    #[Test]
    #[DataProvider('nameProvider')]
    public function Id(string $name): void
    {
        $this->assertions(new Id(name: $name), $name, '[1-9]\d*');
    }

    #[Test]
    #[DataProvider('nameProvider')]
    public function In(string $name): void
    {
        $this->assertions(new In(name: $name, options: ['abc', '123', 'XYZ']), $name, '[abc|123|XYZ]');
    }

    #[Test]
    #[DataProvider('nameProvider')]
    public function numeric(string $name): void
    {
        $patterns = [
            "\d+" => [null, false],
            "[1-9]\d*" => [null, true],
            "\d{%s}" => ['int', false],
            "[1-9]\d{%s}" => ['int', true],
            "\d{,%s}" => ['max', false],
            "[1-9]\d{,%s}" => ['max', true],
            "\d{%s,}" => ['min', false],
            "[1-9]\d{%s,}" => ['min', true],
            "\d{%s,%s}" => ['range', false],
            "[1-9]\d{%s,%s}" => ['range', true],
        ];

        foreach ($patterns as $patternTemplate => $config) {
            [$lengthType, $nonZero] = $config;

            $length = $this->getLength($lengthType);
            $lengthAdjust = $nonZero ? 1 : 0;

            $pattern = match ($lengthType) {
                'int' => sprintf($patternTemplate, $length - $lengthAdjust),
                'max' => sprintf($patternTemplate, $length['max'] - $lengthAdjust),
                'min' => sprintf($patternTemplate, $length['min'] - $lengthAdjust),
                'range' => sprintf(
                    $patternTemplate,
                    $length['min'] - $lengthAdjust,
                    $length['max'] - $lengthAdjust
                ),
                default => $patternTemplate
            };

            $this->assertions(new Numeric(name: $name, length: $length, nonZero: $nonZero), $name, $pattern);
        }
    }

    #[Test]
    #[DataProvider('nameProvider')]
    public function pattern(string $name): void
    {
        $pattern = '\d{3}[\da-f]{5}';
        $this->assertions(new Pattern($name, $pattern), $name, $pattern);
    }

    #[Test]
    #[DataProvider('caseProvider')]
    public function uuid(string $name, AlphaCase $case): void
    {
        $pattern = match($case) {
            AlphaCase::insensitive => '[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}',
            AlphaCase::lower => '[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}',
            AlphaCase::upper => '[\dA-F]{8}-[\dA-F]{4}-[\dA-F]{4}-[\dA-F]{4}-[\dA-F]{12}',
        };

        $this->assertions(new Uuid(name: $name, case: $case), $name, $pattern);
    }

    public static function nameProvider(): Generator
    {
        yield [Random::string(random_int(5, 10))];
    }

    public static function caseProvider(): Generator
    {
        foreach (AlphaCase::cases() as $case) {
            $name = self::nameProvider();
            yield [$name->current()[0], $case];
        }
    }

    private function assertions(ParameterInterface $parameter, string $name, string $pattern): void
    {
        self::assertSame($name, $parameter->getName());
        self::assertSame($pattern, $parameter->getPattern());
    }

    private function getLength(?string $lengthType): array|int|null
    {
        return match ($lengthType) {
            'int' => random_int(1, 10),
            'max' => ['max' => random_int(11, 20)],
            'min' => ['min' => random_int(1, 10)],
            'range' => ['min' => random_int(1, 10), 'max' => random_int(11, 20)],
            default => null
        };
    }
}