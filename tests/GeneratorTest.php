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
                        "Route::methods(['GET'], '/test')",
                        "name('test_method1')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\TestController::class, 'method1'])",
                    ],
                    [
                        "Route::methods(['GET'], '/test/method2/{testId:[1-9]\d*}')",
                        "name('test_method2')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\TestController::class, 'method2'])",
                    ],
                    [
                        "Route::methods(['GET'], '/test/method3/{testId:[1-9]\d*}/{userId:[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}}')",
                        "name('test_method3')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\TestController::class, 'method3'])",
                    ],
                    [
                        "Route::methods(['GET'], '/test/method4/{testId:[1-9]\d*}[/{userId:[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}}]')",
                        "name('test_method4')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\TestController::class, 'method4'])",
                    ],
                ]
            ],
            [
                __DIR__
                . DIRECTORY_SEPARATOR . 'resources'
                . DIRECTORY_SEPARATOR . 'Controller'
                . DIRECTORY_SEPARATOR . 'ItemController.php',
                'group1',
                [
                    "Group::create('/group1')",
                    "namePrefix('group1_')",
                    "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\Middleware1')",
                    "routes(...(require __DIR__ . '/routes/group1.php'))"
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