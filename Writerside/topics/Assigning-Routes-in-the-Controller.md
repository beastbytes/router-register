# Assigning Routes in the Controller

Routes are assigned in the controller using PHP Attributes.

```php
<?php

declare(strict_types=1);

namespace App\Product;

use App\Auth\Middleware\IsEnabled;
use App\Auth\Middleware\IsLoggedIn;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\Post;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Route;
use Psr\Http\Message\ResponseInterface;

final class ProductController
{
    // -- class constants, class parameters, constructor, etc
    
    #[Get(route: ProductRoute::product_index)]
    public function index(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
    
    #[Get(route: ProductRoute::product_view)]
    #[Id(name: 'productId')]
    public function view(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
}

```

### Resulting Routes

Running yii router::register from the console will result in the following routes in config/router/routes/default.php

```php
?php

declare(strict_types=1);

use Yiisoft\Router\Route;

return [
    Route::methods(['GET'], '/products')
        ->name('product_index')
        ->action([App\Product\ProductController::class, 'index'])
    ,
    Route::methods(['GET'], '/product/{productId:[1-9]\d*}')
        ->name('product_view')
        ->action([App\Product\ProductController::class, 'view'])
    ,
];
```

and the following in config/router/groups.php

```php
<?php

declare(strict_types=1);

use Yiisoft\Router\Group;

return [
    Group::create()
        ->routes(...(require __DIR__ . '/routes/default.php'))
    ,
];
```