# Defining Groups

Routes can be grouped, e.g. by an API endpoint or version, or frontend/backend. In RouterRegister, a Controller can be
assigned to a group.

A group can assign a prefix to route URIs and/or names, specify hosts and/or middleware
to be applied to all routes in the group.

> If a Controller in not assigned to a group or assigned to a group that does not have a prefix,
> it is in the "default" group.
{style="note"}

> All group definitions with the same prefix must be the same.
{style="note"}

Our products example will have a backend that allows admins to create, edit, and delete products.

## Backend Route Enumeration

```php
<?php

declare(strict_types=1);

namespace App\Backend\Product;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum ProductRoute: string implements RouteInterface
{
    use RouteTrait;

    case product_index = '/products';
    case product_create = '/product/create';
    case product_delete = '/product/delete';
    case product_update = '/product/update/{productId}';
    case product_view = '/product/{productId}';
}
```

## Backend Controller
```php

<?php

declare(strict_types=1);

namespace App\Backend\Product;

use BeastBytes\Router\Register\Attribute\Group;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\Post;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Route;
use Psr\Http\Message\ResponseInterface;

#[Group(prefix: '/admin')]
final class Product Controller
{
    // -- class constants, class parameters, constructor, etc
    
    #[Get(route: ProductRoute::product_index)]
    public function index(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
    
    #[Route(
        methods:[Method::GET, Method::POST], 
        route: ProductRoute::product_create
    )]
    public function create(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
    
    #[Post(route: ProductRoute::product_delete)]
    public function delete(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
    
    // Assumes that there is some middleware that checks that the user
    // is logged in and their account enabled
    #[Route(
        methods:[Method::GET, Method::POST], 
        route: ProductRoute::product_update
    )]
    #[Id(name: 'productId')]
    #[Id(name: 'userId')]
    public function update(
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

Running yii router::register from the console will result in the following routes in config/router/routes/admin.php

```php
?php

declare(strict_types=1);

use Yiisoft\Router\Route;

return [
    Route::methods(['GET'], '/products')
        ->name('product_index')
        ->action([App\Product\ProductController::class, 'index'])
    ,
    Route::methods(['GET','POST'], '/product/delete')
        ->name('product_delete')
        ->action([App\Product\ProductController::class, 'delete'])
    ,
    Route::methods(['GET','POST'], '/product/create')
        ->name('product_create')
        ->action([App\Product\ProductController::class, 'create'])
    ,
    Route::methods(
        ['GET','POST'],
        '/product/update/{productId:[1-9]\d*}'
    )
        ->name('product_update')
        ->action([App\Product\ProductController::class, 'create'])
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
    Group::create('/admin')
        ->routes(...(require __DIR__ . '/routes/admin.php'))
    ,
];
```