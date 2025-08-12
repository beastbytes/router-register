<?php

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Generator as RouteGenerator;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

// This generates routes and groups from the controllers in the resources directory.
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
            //*
            'Method Attributes' => [
                __DIR__
                . DIRECTORY_SEPARATOR . 'resources'
                . DIRECTORY_SEPARATOR . 'Controller'
                . DIRECTORY_SEPARATOR . 'MethodAttributesController.php',
                'default',
                [
                    'Group::create()',
                    "routes(...(require __DIR__ . '/routes/default.php'))"
                ],
                [
                    [
                        "Route::methods(['GET'], '/method-attributes')",
                        "name('method-attributes.method1')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method1'])",
                    ],
                    [
                        "Route::methods(['GET'], '/method-attributes/method2')",
                        "name('method-attributes.method2')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method2'])",
                    ],
                    [
                        "Route::methods(['GET', 'POST'], '/method-attributes/method3/{testId:[1-9]\d*}')",
                        "name('method-attributes.method3')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method3'])",
                    ],
                    [
                        "Route::methods(['POST'], '/method-attributes/method4/{testId:[1-9]\d*}/{userId:[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}}')",
                        "name('method-attributes.method4')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method4'])",
                    ],
                    [
                        "Route::methods(['GET'], '/method-attributes/method5/{testId:[1-9]\d*}[/{userId:[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}}]')",
                        "defaults(['userId' => '00000000-0000-0000-0000-000000000000'])",
                        "name('method-attributes.method5')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method5'])",
                    ],
                    [
                        "Route::methods(['GET'], '/method-attributes/method6/{testId:[1-9]\d*}')",
                        "name('method-attributes.method6')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\MethodLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method6'])",
                    ],
                    [
                        "Route::methods(['GET'], '/method-attributes/method7/{testId:[1-9]\d*}')",
                        "name('method-attributes.method7')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\MethodLevelMiddleware')",
                        "middleware(fn (BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\MethodLevelMiddleware \$middleware) => \$middleware->withParameter(\"test\"))",
                        "middleware(['class' => 'BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\MethodLevelMiddleware', '__construct()' => ['someVar' => 42, ], ])",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method7'])",
                    ],
                    [
                        "Route::methods(['GET'], '/method-attributes/method8/{testId:[1-9]\d*}')",
                        "name('method-attributes.method8')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\MethodLevelMiddleware')",
                        "disableMiddleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\GroupLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method8'])",
                    ],
                    [
                        "Route::methods(['GET'], '/method-attributes/method9/{testId:[1-9]\d*}')",
                        "name('method-attributes.method9')",
                        "host('www.example.com')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method9'])",
                    ],
                    [
                        "Route::methods(['GET'], '/method-attributes/method10/{testId:[1-9]\d*}')",
                        "name('method-attributes.method10')",
                        "hosts('www.example1.com', 'www.example2.com')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method10'])",
                    ],
                    [
                        "Route::methods(['GET'], '/method-attributes/method11/{testId:[1-9]\d*}')",
                        "name('method-attributes.method11')",
                        "hosts('www.example1.com', 'www.example2.com')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\MethodLevelMiddleware')",
                        "middleware(fn (BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\MethodLevelMiddleware \$middleware) => \$middleware->withParameter(\"test\"))",
                        "disableMiddleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\GroupLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method11'])",
                    ],
                    [
                        "Route::methods(['GET'], '/method-attributes/method12/{testId:[1-9]\d*}')",
                        "name('method-attributes.method12')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method12'])",
                        'fallback' => true
                    ],
                    [
                        "Route::methods(['GET'], '/method-attributes/method13/{testId:[1-9]\d*}')",
                        "name('method-attributes.method13')",
                        "override()",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\MethodAttributesController::class, 'method13'])",
                    ],
                ]
            ],
            //*/
            //*
            'Class Attributes' => [
                __DIR__
                . DIRECTORY_SEPARATOR . 'resources'
                . DIRECTORY_SEPARATOR . 'Controller'
                . DIRECTORY_SEPARATOR . 'ClassAttributesController.php',
                'default',
                [
                    "Group::create()",
                    "routes(...(require __DIR__ . '/routes/default.php'))"
                ],
                [
                    [
                        "Route::methods(['GET'], '/class-attributes')",
                        "name('class-attributes.method1')",
                        "hosts('www.example1.com', 'www.example2.com')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware')",
                        "middleware(fn (BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware \$middleware) => \$middleware->withParameter(\"class\"))",
                        "disableMiddleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\GroupLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\ClassAttributesController::class, 'method1'])",
                    ],
                    [
                        "Route::methods(['GET'], '/class-attributes/method2')",
                        "name('class-attributes.method2')",
                        "hosts('www.example1.com', 'www.example2.com')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware')",
                        "middleware(fn (BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware \$middleware) => \$middleware->withParameter(\"class\"))",
                        "disableMiddleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\GroupLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\ClassAttributesController::class, 'method2'])",
                    ],
                    [
                        "Route::methods(['GET'], '/class-attributes/method3/{testId:[1-9]\d*}')",
                        "name('class-attributes.method3')",
                        "hosts('www.example1.com', 'www.example2.com')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware')",
                        "middleware(fn (BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware \$middleware) => \$middleware->withParameter(\"class\"))",
                        "disableMiddleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\GroupLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\ClassAttributesController::class, 'method3'])",
                    ],
                    [
                        "Route::methods(['GET'], '/class-attributes/method4/{testId:[1-9]\d*}/{userId:[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}}')",
                        "name('class-attributes.method4')",
                        "hosts('www.example1.com', 'www.example2.com')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware')",
                        "middleware(fn (BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware \$middleware) => \$middleware->withParameter(\"class\"))",
                        "disableMiddleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\GroupLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\ClassAttributesController::class, 'method4'])",
                    ],
                    [
                        "Route::methods(['GET'], '/class-attributes/method5/{testId:[1-9]\d*}[/{userId:[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}}]')",
                        "name('class-attributes.method5')",
                        "hosts('www.example1.com', 'www.example2.com')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware')",
                        "middleware(fn (BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware \$middleware) => \$middleware->withParameter(\"class\"))",
                        "disableMiddleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\GroupLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\ClassAttributesController::class, 'method5'])",
                    ],
                    [
                        "Route::methods(['GET'], '/class-attributes/method6/{testId:[1-9]\d*}')",
                        "name('class-attributes.method6')",
                        "hosts('www.example1.com', 'www.example2.com')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware')",
                        "middleware(fn (BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware \$middleware) => \$middleware->withParameter(\"class\"))",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\MethodLevelMiddleware')",
                        "middleware(fn (BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\MethodLevelMiddleware \$middleware) => \$middleware->withParameter(\"test\"))",
                        "disableMiddleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\GroupLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\ClassAttributesController::class, 'method6'])",
                    ],
                    [
                        "Route::methods(['GET'], '/class-attributes/method7/{testId:[1-9]\d*}')",
                        "name('class-attributes.method7')",
                        "hosts('www.example1.com', 'www.example2.com', 'www.example.com')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware')",
                        "middleware(fn (BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware \$middleware) => \$middleware->withParameter(\"class\"))",
                        "disableMiddleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\GroupLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\ClassAttributesController::class, 'method7'])",
                    ],
                    [
                        "Route::methods(['GET'], '/class-attributes/method8/{testId:[1-9]\d*}')",
                        "name('class-attributes.method8')",
                        "hosts('www.example1.com', 'www.example2.com', 'www.example.com')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware')",
                        "middleware(fn (BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware \$middleware) => \$middleware->withParameter(\"class\"))",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\MethodLevelMiddleware')",
                        "middleware(fn (BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\MethodLevelMiddleware \$middleware) => \$middleware->withParameter(\"test\"))",
                        "disableMiddleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\GroupLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\ClassAttributesController::class, 'method8'])",
                    ],
                ]
            ],
            //*/
            //*
            'Group Attributes' => [
                __DIR__
                . DIRECTORY_SEPARATOR . 'resources'
                . DIRECTORY_SEPARATOR . 'Controller'
                . DIRECTORY_SEPARATOR . 'GroupAttributeController.php',
                'group1',
                [
                    "Group::create('/group1')",
                    "namePrefix('group1.')",
                    "host('www.example1.com')",
                    "withCors('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\CorsMiddleware')",
                    "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\GroupLevelMiddleware')",
                    "routes(...(require __DIR__ . '/routes/group1.php'))"
                ],
                [
                    [
                        "Route::methods(['GET'], '/group-attribute')",
                        "name('group-attribute.method1')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\GroupAttributeController::class, 'method1'])",
                    ],
                    [
                        "Route::methods(['GET', 'POST'], '/group-attribute/method2/{id:[1-9]\d*}')",
                        "name('group-attribute.method2')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\GroupAttributeController::class, 'method2'])",
                    ],
                    [
                        "Route::methods(['GET'], '/group-attribute/{id:[1-9]\d*}')",
                        "name('group-attribute.method3')",
                        "middleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\ClassLevelMiddleware')",
                        "disableMiddleware('BeastBytes\\Router\\Register\\Tests\\resources\\Middleware\\GroupLevelMiddleware')",
                        "action([BeastBytes\\Router\\Register\\Tests\\resources\\Controller\\GroupAttributeController::class, 'method3'])",
                    ],
                ]
            ],
            //*/
        ] as $file) {
            yield $file;
        };
    }
}