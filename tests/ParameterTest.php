<?php

declare(strict_types=1);

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Attribute\Parameter\Alpha;
use BeastBytes\Router\Register\Attribute\Parameter\AlphaCase;
use BeastBytes\Router\Register\Attribute\Parameter\AlphaNumeric;
use BeastBytes\Router\Register\Attribute\Parameter\Hex;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Parameter\In;
use BeastBytes\Router\Register\Attribute\Parameter\Numeric;
use BeastBytes\Router\Register\Attribute\Parameter\Parameter;
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
            AlphaCase::upper => 'A-Z'
        };

        $attribute = new Alpha(name: $name, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[' . $alpha . ']+', $attribute->getPattern());

        $length = random_int(1, 10);
        $attribute = new Alpha(name: $name, length: $length, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[' . $alpha . ']{' . $length . '}', $attribute->getPattern());

        $length =[random_int(1, 10), random_int(11, 20)];
        [$min, $max] = $length;
        $attribute = new Alpha(name: $name, length: $length, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[' . $alpha . ']{' . $min . ',' . $max . '}', $attribute->getPattern());

        $length =[null, random_int(1, 10)];
        [$min, $max] = $length;
        $attribute = new Alpha(name: $name, length: $length, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[' . $alpha . ']{,' . $max . '}', $attribute->getPattern());

        $length =[random_int(1, 10), null];
        [$min, $max] = $length;
        $attribute = new Alpha(name: $name, length: $length, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[' . $alpha . ']{' . $min . ',}', $attribute->getPattern());
    }

    #[Test]
    #[DataProvider('caseProvider')]
    public function alphaNumeric(string $name, AlphaCase $case): void
    {
        $alpha = match($case) {
            AlphaCase::insensitive => 'a-zA-Z',
            AlphaCase::lower => 'a-z',
            AlphaCase::upper => 'A-Z'
        };

        $attribute = new AlphaNumeric(name: $name, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[\d' . $alpha . ']+', $attribute->getPattern());

        $length = random_int(1, 10);
        $attribute = new AlphaNumeric(name: $name, length: $length, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[\d' . $alpha . ']{' . $length . '}', $attribute->getPattern());

        $length =[random_int(1, 10), random_int(11, 20)];
        [$min, $max] = $length;
        $attribute = new AlphaNumeric(name: $name, length: $length, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[\d' . $alpha . ']{' . $min . ',' . $max . '}', $attribute->getPattern());

        $length =[null, random_int(1, 10)];
        [$min, $max] = $length;
        $attribute = new AlphaNumeric(name: $name, length: $length, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[\d' . $alpha . ']{,' . $max . '}', $attribute->getPattern());

        $length =[random_int(1, 10), null];
        [$min, $max] = $length;
        $attribute = new AlphaNumeric(name: $name, length: $length, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[\d' . $alpha . ']{' . $min . ',}', $attribute->getPattern());
    }

    #[Test]
    #[DataProvider('caseProvider')]
    public function Hex(string $name, AlphaCase $case): void
    {
        $alpha = match($case) {
            AlphaCase::insensitive => 'a-fA-F',
            AlphaCase::lower => 'a-f',
            AlphaCase::upper => 'A-F'
        };

        $attribute = new Hex(name: $name, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[\d' . $alpha . ']+', $attribute->getPattern());

        $attribute = new Hex(name: $name, case: $case, nonZero: true);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[1-9' . $alpha . '][\d' . $alpha . ']*', $attribute->getPattern());

        $length = random_int(1, 10);
        $attribute = new Hex(name: $name, length: $length, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[\d' . $alpha . ']{' . $length . '}', $attribute->getPattern());

        $attribute = new Hex(name: $name, length: $length, case: $case, nonZero: true);
        --$length;
        self::assertSame($name, $attribute->getName());
        self::assertSame(
            '[1-9' . $alpha . '][\d' . $alpha . ']{' . $length . '}',
            $attribute->getPattern()
        );

        $length = [random_int(1, 10), random_int(11, 20)];
        [$min, $max] = $length;
        $attribute = new Hex(name: $name, length: $length, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[\d' . $alpha . ']{' . $min . ',' . $max . '}', $attribute->getPattern());

        $attribute = new Hex(name: $name, length: $length, case: $case, nonZero: true);
        --$min;
        --$max;
        self::assertSame($name, $attribute->getName());
        self::assertSame(
            '[1-9' . $alpha . '][\d' . $alpha . ']{' . ($min ?? '') . ',' . $max . '}',
            $attribute->getPattern()
        );

        $length = [null, random_int(1, 10)];
        [$min, $max] = $length;
        $attribute = new Hex(name: $name, length: $length, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[\d' . $alpha . ']{,' . $max . '}', $attribute->getPattern());

        $attribute = new Hex(name: $name, length: $length, case: $case, nonZero: true);
        --$max;
        self::assertSame($name, $attribute->getName());
        self::assertSame(
            '[1-9' . $alpha . '][\d' . $alpha . ']{,' . $max . '}',
            $attribute->getPattern()
        );

        $length = [random_int(1, 10), null];
        [$min, $max] = $length;
        $attribute = new Hex(name: $name, length: $length, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[\d' . $alpha . ']{' . $min . ',}', $attribute->getPattern());

        $attribute = new Hex(name: $name, length: $length, case: $case, nonZero: true);
        --$min;
        self::assertSame($name, $attribute->getName());
        self::assertSame(
            '[1-9' . $alpha . '][\d' . $alpha . ']{' . $min . ',}',
            $attribute->getPattern()
        );
    }

    #[Test]
    #[DataProvider('nameProvider')]
    public function Id(string $name): void
    {
        $attribute = new Id(name: $name);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[1-9]\d*', $attribute->getPattern());
    }

    #[Test]
    #[DataProvider('nameProvider')]
    public function In(string $name): void
    {
        $attribute = new In(name: $name, options: ['abc', '123', 'XYZ']);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[abc|123|XYZ]', $attribute->getPattern());
    }

    #[Test]
    #[DataProvider('nameProvider')]
    public function numeric(string $name): void
    {
        $attribute = new Numeric(name: $name);
        self::assertSame($name, $attribute->getName());
        self::assertSame('\d+', $attribute->getPattern());

        $attribute = new Numeric(name: $name, nonZero: true);
        self::assertSame($name, $attribute->getName());
        self::assertSame('[1-9]\d*', $attribute->getPattern());

        $length = random_int(1, 10);
        $attribute = new Numeric(name: $name, length: $length);
        self::assertSame($name, $attribute->getName());
        self::assertSame('\d{' . $length . '}', $attribute->getPattern());

        $attribute = new Numeric(name: $name, length: $length, nonZero: true);
        --$length;
        self::assertSame($name, $attribute->getName());
        self::assertSame('[1-9]\d{' . $length . '}', $attribute->getPattern());

        $length = [random_int(1, 10), random_int(11, 20)];
        [$min, $max] = $length;
        $attribute = new Numeric(name: $name, length: $length);
        self::assertSame($name, $attribute->getName());
        self::assertSame('\d{' . $min . ',' . $max . '}', $attribute->getPattern());

        $attribute = new Numeric(name: $name, length: $length, nonZero: true);
        --$min;
        --$max;
        self::assertSame($name, $attribute->getName());
        self::assertSame('[1-9]\d{' . $min . ',' . $max . '}', $attribute->getPattern());

        $length = [null, random_int(1, 10)];
        [$min, $max] = $length;
        $attribute = new Numeric(name: $name, length: $length);
        self::assertSame($name, $attribute->getName());
        self::assertSame('\d{,' . $max . '}', $attribute->getPattern());

        $attribute = new Numeric(name: $name, length: $length, nonZero: true);
        --$max;
        self::assertSame($name, $attribute->getName());
        self::assertSame('[1-9]\d{,' . $max . '}', $attribute->getPattern());

        $length = [random_int(1, 10), null];
        [$min, $max] = $length;
        $attribute = new Numeric(name: $name, length: $length);
        self::assertSame($name, $attribute->getName());
        self::assertSame('\d{' . $min . ',}', $attribute->getPattern());

        $attribute = new Numeric(name: $name, length: $length, nonZero: true);
        --$min;
        self::assertSame($name, $attribute->getName());
        self::assertSame('[1-9]\d{' . $min . ',}', $attribute->getPattern());
    }

    #[Test]
    #[DataProvider('nameProvider')]
    public function parameter(string $name): void
    {
        $pattern = '\d{3}[\da-f]{5}';
        $attribute = new Parameter($name, $pattern);
        self::assertSame($name, $attribute->getName());
        self::assertSame($pattern, $attribute->getPattern());
    }

    #[Test]
    #[DataProvider('caseProvider')]
    public function uuid(string $name, AlphaCase $case): void
    {
        $pattern = match($case) {
            AlphaCase::insensitive => '[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}',
            AlphaCase::lower => '[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}',
            AlphaCase::upper => '[\dA-F]{8}-[\dA-F]{4}-[\dA-F]{4}-[\dA-F]{4}-[\dA-F]{12}'
        };

        $attribute = new Uuid(name: $name, case: $case);
        self::assertSame($name, $attribute->getName());
        self::assertSame($pattern, $attribute->getPattern());
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
}