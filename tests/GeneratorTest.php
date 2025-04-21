<?php

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Generator as RouteGenerator;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class GeneratorTest extends TestCase
{
    #[Test]
    public function defaultGroupName(): void
    {
        $defaultGroup = 'defaultGroup';

        $generator = new RouteGenerator();
        $generator->setDefaultGroup($defaultGroup);

        $reflectionGenerator = new ReflectionClass($generator);
        $reflectionProperty = $reflectionGenerator->getProperty('defaultGroup');
        self::assertSame($defaultGroup, $reflectionProperty->getValue($generator));
    }

    #[Test]
    #[DataProvider('fileProvider')]
    public function processFile(string $file, string $name, array $group, array $routes): void
    {
        $defaultGroup = 'default';

        $generator = new RouteGenerator();
        $generator->setDefaultGroup($defaultGroup);

        [$generatedName, $generatedGroup, $generatedRoutes] = $generator->processFile($file);
        self::assertSame($name, $generatedName);
        self::assertSame($group, $generatedGroup);
        self::assertSame($routes, $generatedRoutes);
    }

    public static function fileProvider(): Generator
    {
        foreach ([
            [
                __DIR__
                . DIRECTORY_SEPARATOR . 'resources'
                . DIRECTORY_SEPARATOR . 'Controller'
                . DIRECTORY_SEPARATOR . 'TestController.php',
                'default',
                [
                    'Group::create()',
                    "routes(...(require __DIR__ . '/routes/default.php'))"
                ],
                [
                    [
                        "Route::methods(['GET'], '/index')",
                        "name('test_index')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\TestController::class, 'index'])",
                    ],
                    [
                        "Route::methods(['GET'], '/test/{testId:[1-9]\d*}/{userId:[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}}')",
                        "name('test_user')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\TestController::class, 'user'])",
                    ],
                    [
                        "Route::methods(['GET'], '/test/{testId:[1-9]\d*}')",
                        "name('test_view')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\TestController::class, 'view'])",
                    ],
                ]
            ],
            [
                __DIR__
                . DIRECTORY_SEPARATOR . 'resources'
                . DIRECTORY_SEPARATOR . 'Controller'
                . DIRECTORY_SEPARATOR . 'ItemController.php',
                'admin',
                [
                    "Group::create('/admin')",
                    "routes(...(require __DIR__ . '/routes/admin.php'))"
                ],
                [
                    [
                        "Route::methods(['GET'], '/index')",
                        "name('item_index')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\ItemController::class, 'index'])",
                    ],
                    [
                        "Route::methods(['GET','POST'], '/item/update/{itemId:[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}}')",
                        "name('item_update')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\ItemController::class, 'update'])",
                    ],
                    [
                        "Route::methods(['GET'], '/item/{itemId:[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}}')",
                        "name('item_view')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\ItemController::class, 'view'])",
                    ],
                ]
            ],
        ] as $file) {
            yield $file;
        };
    }
}