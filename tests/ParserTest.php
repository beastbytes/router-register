<?php

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Attribute\Cors;
use BeastBytes\Router\Register\Attribute\DefaultValue;
use BeastBytes\Router\Register\Attribute\Fallback;
use BeastBytes\Router\Register\Attribute\Host;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\GetPost;
use BeastBytes\Router\Register\Attribute\Method\Post;
use BeastBytes\Router\Register\Attribute\Middleware;
use BeastBytes\Router\Register\Attribute\Override;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Parameter\Uuid;
use BeastBytes\Router\Register\DTO\Group;
use BeastBytes\Router\Register\DTO\Route;
use BeastBytes\Router\Register\Parser as RouteGenerator;
use BeastBytes\Router\Register\Tests\resources\Controller\ClassAttributesController;
use BeastBytes\Router\Register\Tests\resources\Controller\ClassAttributesRoute;
use BeastBytes\Router\Register\Tests\resources\Controller\GroupAttributesController;
use BeastBytes\Router\Register\Tests\resources\Controller\GroupAttributesRoute;
use BeastBytes\Router\Register\Tests\resources\Controller\GroupWithPrefixAttributesController;
use BeastBytes\Router\Register\Tests\resources\Controller\GroupWithPrefixAttributesRoute;
use BeastBytes\Router\Register\Tests\resources\Controller\MethodAttributesController;
use BeastBytes\Router\Register\Tests\resources\Controller\MethodAttributesRoute;
use BeastBytes\Router\Register\Tests\resources\Middleware\ClassLevelMiddleware;
use BeastBytes\Router\Register\Tests\resources\Middleware\CorsMiddleware;
use BeastBytes\Router\Register\Tests\resources\Middleware\GroupLevelMiddleware;
use BeastBytes\Router\Register\Tests\resources\Middleware\MethodLevelMiddleware;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    #[Test]
    #[DataProvider('fileProvider')]
    public function parse(string $file, string $name, Group $group): void
    {
        $groups = (new RouteGenerator())->processFiles([$file]);

        self::assertArrayHasKey($name, $groups);
        self::assertEquals($group, $groups[$name]);
    }

    public static function fileProvider(): Generator
    {
        $classAttributesGroup = Group::create('class-attributes', '/class-attributes');
        $groupAttributesGroup = Group::create('group-attributes', '/group-attributes');
        $groupWithPrefixAttributesGroup = Group::create(
            'group-attributes',
            null
        );
        $methodAttributesGroup = Group::create('method-attributes', '/method-attributes');

        yield 'Method Attributes' => [
            __DIR__
                . DIRECTORY_SEPARATOR . 'resources'
                . DIRECTORY_SEPARATOR . 'Controller'
                . DIRECTORY_SEPARATOR . 'MethodAttributesController.php'
            ,
            'routes',
            Group::create('routes')
                ->route(
                    Route::create(new Get(MethodAttributesRoute::method14))
                        ->parameters([new Id('testId')])
                        ->action(new Middleware([MethodAttributesController::class, 'method14']))
                        ->group($methodAttributesGroup)
                )
                ->route(
                    $methodAttributesGroup
                        ->route(
                            Route::create(new Get(MethodAttributesRoute::method1))
                                ->action(new Middleware([MethodAttributesController::class, 'method1']))
                                ->group($methodAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(MethodAttributesRoute::method2))
                                ->action(new Middleware([MethodAttributesController::class, 'method2']))
                                ->group($methodAttributesGroup)
                        )
                        ->route(
                            Route::create(new GetPost(MethodAttributesRoute::method3))
                                ->parameters([new Id('testId')])
                                ->action(new Middleware([MethodAttributesController::class, 'method3']))
                                ->group($methodAttributesGroup)
                        )
                        ->route(
                            Route::create(new Post(MethodAttributesRoute::method4))
                                ->parameters([
                                    new Id('testId'),
                                    new Uuid('userId')
                                ])
                                ->action(new Middleware([MethodAttributesController::class, 'method4']))
                                ->group($methodAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(MethodAttributesRoute::method5))
                                ->parameters([
                                    new Id('testId'),
                                    new Uuid('userId')
                                ])
                                ->defaultValues([new DefaultValue(
                                    'userId',
                                    '00000000-0000-0000-0000-000000000000'
                                )])
                                ->action(new Middleware([MethodAttributesController::class, 'method5']))
                                ->group($methodAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(MethodAttributesRoute::method6))
                                ->parameters([new Id('testId')])
                                ->middlewares([new Middleware(MethodLevelMiddleware::class)])
                                ->action(new Middleware([MethodAttributesController::class, 'method6']))
                                ->group($methodAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(MethodAttributesRoute::method7))
                                ->parameters([new Id('testId')])
                                ->middlewares([
                                    new Middleware(MethodLevelMiddleware::class),
                                    new Middleware(
                                        'fn ('
                                        . MethodLevelMiddleware::class
                                        . ' $middleware) => $middleware->withParameter("test")'
                                    ),
                                    new Middleware([
                                        'class' => MethodLevelMiddleware::class,
                                        '__construct()' => ['someVar' => 42]
                                    ])
                                ])
                                ->action(new Middleware([MethodAttributesController::class, 'method7']))
                                ->group($methodAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(MethodAttributesRoute::method8))
                                ->parameters([new Id('testId')])
                                ->middlewares([
                                    new Middleware(MethodLevelMiddleware::class),
                                    new Middleware(
                                        GroupLevelMiddleware::class,
                                        Middleware::DISABLE
                                    )
                                ])
                                ->action(new Middleware([MethodAttributesController::class, 'method8']))
                                ->group($methodAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(MethodAttributesRoute::method9))
                                ->parameters([new Id('testId')])
                                ->hosts([new Host('https://www.example.com')])
                                ->action(new Middleware([MethodAttributesController::class, 'method9']))
                                ->group($methodAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(MethodAttributesRoute::method10))
                                ->parameters([new Id('testId')])
                                ->hosts([
                                    new Host('https://www.example1.com'),
                                    new Host('https://www.example2.com'),
                                ])
                                ->action(new Middleware([MethodAttributesController::class, 'method10']))
                                ->group($methodAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(MethodAttributesRoute::method11))
                                ->parameters([new Id('testId')])
                                ->hosts([
                                    new Host('https://www.example1.com'),
                                    new Host('https://www.example2.com'),
                                ])
                                ->middlewares([
                                    new Middleware(MethodLevelMiddleware::class),
                                    new Middleware(
                                        'fn ('
                                        . MethodLevelMiddleware::class
                                        . ' $middleware) => $middleware->withParameter("test")'
                                    ),
                                    new Middleware(GroupLevelMiddleware::class, Middleware::DISABLE)
                                ])
                                ->action(new Middleware([MethodAttributesController::class, 'method11']))
                                ->group($methodAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(MethodAttributesRoute::method12))
                                ->parameters([new Id('testId')])
                                ->action(new Middleware([MethodAttributesController::class, 'method12']))
                                ->fallback(new Fallback())
                                ->group($methodAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(MethodAttributesRoute::method13))
                                ->parameters([new Id('testId')])
                                ->action(new Middleware([MethodAttributesController::class, 'method13']))
                                ->override(new Override())
                                ->group($methodAttributesGroup)
                        )
                )
        ];
        yield 'Class Attributes' => [
            __DIR__
                . DIRECTORY_SEPARATOR . 'resources'
                . DIRECTORY_SEPARATOR . 'Controller'
                . DIRECTORY_SEPARATOR . 'ClassAttributesController.php'
            ,
            'group2',
            Group::create('group2', '/g2')
                ->hosts([new Host('https://www.example.com')])
                ->route(
                    $classAttributesGroup
                        ->hosts([
                            new Host('https://www.example1.com'),
                            new Host('https://www.example2.com'),
                        ])
                        ->middlewares([
                            new Middleware(ClassLevelMiddleware::class),
                            new Middleware(
                                'fn ('
                                . ClassLevelMiddleware::class
                                . ' $middleware) => $middleware->withParameter("class")'
                            ),
                            new Middleware(GroupLevelMiddleware::class, Middleware::DISABLE),

                        ])
                        ->route(
                            Route::create(new Get(ClassAttributesRoute::method1))
                                ->action(new Middleware([ClassAttributesController::class, 'method1']))
                                ->group($classAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(ClassAttributesRoute::method2))
                                ->action(new Middleware([ClassAttributesController::class, 'method2']))
                                ->group($classAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(ClassAttributesRoute::method3))
                                ->parameters([new Id('testId')])
                                ->action(new Middleware([ClassAttributesController::class, 'method3']))
                                ->group($classAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(ClassAttributesRoute::method4))
                                ->parameters([
                                    new Id('testId'),
                                    new Uuid('userId')
                                ])
                                ->action(new Middleware([ClassAttributesController::class, 'method4']))
                                ->group($classAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(ClassAttributesRoute::method5))
                                ->parameters([
                                    new Id('testId'),
                                    new Uuid('userId')
                                ])
                                ->action(new Middleware([ClassAttributesController::class, 'method5']))
                                ->group($classAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(ClassAttributesRoute::method6))
                                ->parameters([new Id('testId')])
                                ->middlewares([
                                    new Middleware(MethodLevelMiddleware::class),
                                    new Middleware(
                                        'fn ('
                                        . MethodLevelMiddleware::class
                                        . ' $middleware) => $middleware->withParameter("test")'
                                    ),
                                ])
                                ->action(new Middleware([ClassAttributesController::class, 'method6']))
                                ->group($classAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(ClassAttributesRoute::method7))
                                ->parameters([new Id('testId')])
                                ->hosts([new Host('https://www.example.com')])
                                ->action(new Middleware([ClassAttributesController::class, 'method7']))
                                ->group($classAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(ClassAttributesRoute::method8))
                                ->parameters([new Id('testId')])
                                ->hosts([new Host('https://www.example.com')])
                                ->middlewares([
                                    new Middleware(MethodLevelMiddleware::class),
                                    new Middleware(
                                        'fn ('
                                        . MethodLevelMiddleware::class
                                        . ' $middleware) => $middleware->withParameter("test")'
                                    ),
                                ])
                                ->action(new Middleware([ClassAttributesController::class, 'method8']))
                                ->group($classAttributesGroup)
                        )
                )
        ];
        yield 'Group Attributes' => [
            __DIR__
            . DIRECTORY_SEPARATOR . 'resources'
            . DIRECTORY_SEPARATOR . 'Controller'
            . DIRECTORY_SEPARATOR . 'GroupAttributesController.php'
            ,
            'group1',
            Group::create('group1', '/g1')
                ->hosts([new Host('https://www.example.com')])
                ->cors(new Cors(CorsMiddleware::class))
                ->middlewares([new Middleware(GroupLevelMiddleware::class)])
                ->route(
                    $groupAttributesGroup
                        ->middlewares([new Middleware(ClassLevelMiddleware::class)])
                        ->route(
                            Route::create(new Get(GroupAttributesRoute::method1))
                                ->action(new Middleware([GroupAttributesController::class, 'method1']))
                                ->group($groupAttributesGroup)
                        )
                        ->route(
                            Route::create(new GetPost(GroupAttributesRoute::method2))
                                ->parameters([new Id('id')])
                                ->action(new Middleware([GroupAttributesController::class, 'method2']))
                                ->group($groupAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(GroupAttributesRoute::method3))
                                ->parameters([new Id('id')])
                                ->middlewares([
                                    new Middleware(
                                        GroupLevelMiddleware::class,
                                        Middleware::DISABLE
                                    )
                                ])
                                ->action(new Middleware([GroupAttributesController::class, 'method3']))
                                ->group($groupAttributesGroup)
                        )
                )
        ];
        yield 'Group With Prefix Attributes' => [
            __DIR__
            . DIRECTORY_SEPARATOR . 'resources'
            . DIRECTORY_SEPARATOR . 'Controller'
            . DIRECTORY_SEPARATOR . 'GroupWithPrefixAttributesController.php'
            ,
            'group1',
            Group::create('group1', '/example/{locale:[a-z]{2}}/g1')
                ->hosts([new Host('https://www.example.com')])
                ->cors(new Cors(CorsMiddleware::class))
                ->middlewares([new Middleware(GroupLevelMiddleware::class)])
                ->route(
                    $groupWithPrefixAttributesGroup
                        ->middlewares([new Middleware(ClassLevelMiddleware::class)])
                        ->route(
                            Route::create(new Get(GroupWithPrefixAttributesRoute::method1))
                                ->action(new Middleware([GroupWithPrefixAttributesController::class, 'method1']))
                                ->group($groupWithPrefixAttributesGroup)
                        )
                        ->route(
                            Route::create(new GetPost(GroupWithPrefixAttributesRoute::method2))
                                ->parameters([new Id('id')])
                                ->action(new Middleware([GroupWithPrefixAttributesController::class, 'method2']))
                                ->group($groupWithPrefixAttributesGroup)
                        )
                        ->route(
                            Route::create(new Get(GroupWithPrefixAttributesRoute::method3))
                                ->parameters([new Id('id')])
                                ->middlewares([
                                    new Middleware(
                                        GroupLevelMiddleware::class,
                                        Middleware::DISABLE
                                    )
                                ])
                                ->action(new Middleware([GroupWithPrefixAttributesController::class, 'method3']))
                                ->group($groupWithPrefixAttributesGroup)
                        )

                )
        ];
    }
}