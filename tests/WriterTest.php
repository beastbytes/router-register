<?php

namespace BeastBytes\Router\Register\Tests;

use BeastBytes\Router\Register\Writer;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class WriterTest extends TestCase
{
    private array $content;
    private array $groups;
    private string $path;

    protected function setUp(): void
    {
        $this->path = __DIR__ . DIRECTORY_SEPARATOR . 'output';
        $this->groups = [
            'default' => [
                'group' => [
                    'Group::create()',
                    "routes(...(require __DIR__ . '/routes/default.php'))"
                ],
                'routes' => [
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
            'admin' => [
                'group' => [
                    "Group::create('/admin')",
                    "routes(...(require __DIR__ . '/routes/admin.php'))"
                ],
                'routes' => [
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
        ];

        $this->content['groups'] = <<<'GROUPS'
<?php

declare(strict_types=1);

use Yiisoft\Router\Group;

return [
    Group::create()
        ->routes(...(require __DIR__ . '/routes/default.php'))
    ,
    Group::create('/admin')
        ->routes(...(require __DIR__ . '/routes/admin.php'))
    ,
];
GROUPS;

        $this->content['routes']['default'] = <<<'DEFAULT'
<?php

declare(strict_types=1);

use Yiisoft\Router\Route;

return [
    Route::methods(['GET'], '/index')
        ->name('test_index')
        ->action([BeastBytes\Router\Register\Tests\resources\Controller\MethodAttributesController::class, 'index'])
    ,
    Route::methods(['GET'], '/test/{testId:[1-9]\d*}/{userId:[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}}')
        ->name('test_user')
        ->action([BeastBytes\Router\Register\Tests\resources\Controller\MethodAttributesController::class, 'user'])
    ,
    Route::methods(['GET'], '/test/{testId:[1-9]\d*}')
        ->name('test_view')
        ->action([BeastBytes\Router\Register\Tests\resources\Controller\MethodAttributesController::class, 'view'])
    ,
];
DEFAULT;

        $this->content['routes']['admin'] = <<<'ADMIN'
<?php

declare(strict_types=1);

use Yiisoft\Router\Route;

return [
    Route::methods(['GET'], '/index')
        ->name('item_index')
        ->action([BeastBytes\Router\Register\Tests\resources\Controller\TestController::class, 'index'])
    ,
    Route::methods(['GET','POST'], '/item/update/{itemId:[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}}')
        ->name('item_update')
        ->action([BeastBytes\Router\Register\Tests\resources\Controller\TestController::class, 'update'])
    ,
    Route::methods(['GET'], '/item/{itemId:[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}}')
        ->name('item_view')
        ->action([BeastBytes\Router\Register\Tests\resources\Controller\TestController::class, 'view'])
    ,
];
ADMIN;
    }

    protected function tearDown(): void
    {
        unlink($this->path . DIRECTORY_SEPARATOR . '*.php');
        unlink($this->path . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . '*.php');
    }

    #[Test]
    public function defaultGroupName(): void
    {
        $writer = new Writer();
        $writer->setPath($this->path);

        $reflectionWriter = new ReflectionClass($writer);
        $reflectionProperty = $reflectionWriter->getProperty('path');
        self::assertSame($this->path, $reflectionProperty->getValue($writer));
    }

    #[Test]
    public function write()
    {
        $writer = new Writer();
        $writer->setPath($this->path);
        $writer->write($this->groups);

        $filename = $this->path . DIRECTORY_SEPARATOR . 'groups.php';
        self::assertFileExists($filename);
        self::assertSame(
            $this->content['groups'],
            file_get_contents($filename)
        );

        foreach (array_keys($this->groups) as $group) {
            $filename = $this->path . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . $group . '.php';
            self::assertFileExists($filename);
            self::assertSame(
                $this->content['routes'][$group],
                file_get_contents($filename)
            );
        }
    }
}