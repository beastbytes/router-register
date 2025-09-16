# Assigning Routes and Groups in Source Code
Routes and Groups are assigned in controllers using PHP Attributes.

## Routes
Routes are assigned to methods using either one of the [HTTP Method attributes](HTTP-Methods.md)
or the [Route attribute](Other-Route-Attributes.md#route) when multiple Methods are needed.

### Route Parameters
If the route has parameters, each parameter is defined by one of the [Route Parameters](Route-Parameters.md).
There are Route Parameters to cover most use cases:
* [Alpha](Route-Parameters.md#alpha) — alphabetic string; length and case can be specified
* [AlphaNumeric](Route-Parameters.md#alphanumeric) — alphanumeric string; length and case can be specified
* [Hex](Route-Parameters.md#hex) — hexadecimal string; length and case can be specified
* [Id](Route-Parameters.md#id) — a number greater than 0
* [In](Route-Parameters.md#in) — list of allowed values
* [Numeric](Route-Parameters.md#numeric) — a number
* [Uuid](Route-Parameters.md#uuid) — a RFC 4122 universally unique identifier

The [Parameter attribute](Route-Parameters.md#parameter) defines the pattern to match for all other cases.

The [DefaultValue attribute](Route-Parameters.md#defaultvalue) can be used to define a default value for a parameter.

## Other Method Level Attributes
Other attributes can be used to define the route, e.g. middleware to be applied. These are:
* [Fallback](Other-Route-Attributes.md#fallback) — Defines a fallback route that is attempted if
no other routes in a group match. Only one fallback route is permitted in a group.
* [Host](Other-Route-Attributes.md#host) — Defines the host(s) the route applies to.
* [Middleware](Other-Route-Attributes.md#middleware) — Defines the middleware(s) to apply the route.
Can also disable group or class level middleware by setting the `disable` parameter to `false`.

Application specific Middleware attributes can be defined;
see [Defining Middleware Attributes](Defining-Middleware-Attributes.md)
* [Override](Other-Route-Attributes.md#override) — Overrides (replaces) a route with the same name.

## Class Level Attributes
If a Route attribute parameter applies to all routes in a controller, e.g. middleware to be applied,
a class level attribute, e.g. `Middleware` can be used to save having to define it for each route.

Class level attributes are:
* [DefaultValue](Route-Parameters.md#defaultvalue) — Defines the default value to all routes in the class that use the parameter.
* [Host](Other-Route-Attributes.md#host) — Defines the host(s) the routes apply to.
* [Middleware](Other-Route-Attributes.md#middleware) — Defines the middleware(s) to apply to all routes in the class.

Application specific Middleware attributes can be defined;
see [Defining Middleware Attributes](Defining-Middleware-Attributes.md)
Can also disable group level middleware by setting the `disable` parameter to `false`.

## Groups
Routes can be grouped, e.g. by API endpoint or version, frontend/backend, etc.
In RouterRegister, a Controller is assigned to a group.

> If a Controller is not explicitly assigned to a group, it is in the "default" group.
{style="note"}

A group can assign a prefix to route URIs, route name, specify hosts, and middleware
to be applied, or middleware not to be applied, to all routes in the group.

If a group requires more than just the route and name prefixes, 
e.g. a middleware that applies to controller methods in the group,
one of the controllers must specify all the required parameters; 
other controllers in the group need only specify the group.

> If specifying required group parameters in one controller, it is best do so in the _root_ controller of the group,

## Example
We will use an item list to illustrate defining and assigning routes.
On the frontend, users who are logged in (to illustrate class level attributes)
can view item categories, items in a category, and individual items.
The backend has a dashboard and allows admins to manage categories and items.

### Route Group
```php
<?php

declare(strict_types=1);

namespace App;

use BeastBytes\Router\Register\GroupInterface;
use BeastBytes\Router\Register\GroupTrait;

enum RouteGroup implements GroupInterface
{
    use GroupTrait;

    case admin;
}
```

### Backend Routes
#### Admin
```php
<?php

declare(strict_types=1);

namespace App\Admin;

use App\RouteGroup;
use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum AdminRoute: string implements RouteInterface
{
    use RouteTrait;
    
    private const GROUP = RouteGroup::admin->name;

    case dashboard => '/';
}
```

#### Category
```php
<?php

declare(strict_types=1);

namespace App\Admin\Category;

use App\RouteGroup;
use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum CategoryRoute: string implements RouteInterface
{
    use RouteTrait;
    
    private const GROUP = RouteGroup::admin->name;
    public const PREFIX = 'category';
    public const SEPARATOR = '_';

    case index => '//categories';
    case create => '/create';
    case delete => '/delete/{id}';
    case update => '/update/{id}';
    case view => '/{id}';
}
```

#### Item
```php
<?php

declare(strict_types=1);

namespace App\Admin\Item;

use App\RouteGroup;
use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum ItemRoute: string implements RouteInterface
{
    use RouteTrait;
    
    private const GROUP = RouteGroup::admin->name;
    public const PREFIX = 'item';

    case index => '//items';
    case create => '/create';
    case delete => '/delete/{id}';
    case update => '/update/{id}';
    case view => '/{id}';
}
```

### Frontend Routes
```php
<?php

declare(strict_types=1);

namespace App;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum FrontendRoute: string implements RouteInterface
{
    use RouteTrait;

    case categories => '/categories';
    case category => '/category/{id}';
    case item => '/item/{id}';
}
```

### Backend Controllers
#### Admin Controller
```php
<?php

declare(strict_types=1);

namespace App\Admin;

use App\Auth\Middleware\IsEnabled;
use App\Auth\Middleware\IsLoggedIn;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\Post;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Route;
use Psr\Http\Message\ResponseInterface;

#[Group(group: RouteGroup::admin, middleware: [IsLoggedIn::class, IsEnabled::class])]
final class Controller
{
    // -- class constants, class parameters, constructor, etc
    
    #[Get(route: Route::dashboard)]
    public function index(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
}
```

#### Category Controller
```php
<?php

declare(strict_types=1);

namespace App\Admin\Category;

use App\Admin\RouteGroup;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\Method;
use BeastBytes\Router\Register\Attribute\Method\Post;
use BeastBytes\Router\Register\Attribute\Method\Prefix;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Route;
use Psr\Http\Message\ResponseInterface;

#[Group(group: RouteGroup::admin)]
final class CategoryController
{
    // -- class constants, class parameters, constructor, etc
    
    #[Get(route: CategoryRoute::category_index)]
    public function index(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
    
    #[GetPost(route: CategoryRoute::category_create)]
    #[Id(name: 'id')]
    public function create(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
    
    #[Post(route: CategoryRoute::delete)]
    #[Id(name: 'id')]
    public function delete(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
    
    #[GetPost(route: CategoryRoute::category_update)]
    #[Id(name: 'id')]
    public function update(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
    
    #[Get(route: CategoryRoute::category_view)]
    #[Id(name: 'id')]
    public function view(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
}
```

#### Item Controller
```php
<?php

declare(strict_types=1);

namespace App\Admin\Item;

use App\Admin\RouteGroup;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Method\Method;
use BeastBytes\Router\Register\Attribute\Method\Post;
use BeastBytes\Router\Register\Attribute\Method\Prefix;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Attribute\Route;
use Psr\Http\Message\ResponseInterface;

#[Group(group: RouteGroup::admin)]
final class ItemController
{
    // -- class constants, class parameters, constructor, etc
    
    #[Get(route: ItemRoute::index)]
    public function index(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
    
    #[GetPost(route: ItemRoute::create)]
    #[Id(name: 'id')]
    public function create(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
    
    #[Post(route: ItemRoute::delete)]
    #[Id(name: 'id')]
    public function delete(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
    
    #[GetPost(route: ItemRoute::update)]
    #[Id(name: 'id')]
    public function update(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
    
    #[Get(route: ItemRoute::view)]
    #[Id(name: 'id')]
    public function update(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
}
```

### FrontendController
```php
<?php

declare(strict_types=1);

namespace App;

use App\Auth\Middleware\IsLoggedIn;
use BeastBytes\Router\Register\Attribute\Method\Get;
use BeastBytes\Router\Register\Attribute\Parameter\Id;
use BeastBytes\Router\Register\Middleware;
use Psr\Http\Message\ResponseInterface;

#[Middleware(IsLoggedIn::class)]
final class FrontendController
{
    // -- class constants, class parameters, constructor, etc
    
    #[Get(route: FrontendRoute::categories)]
    public function index(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
 
    #[Get(route: FrontendRoute::category)]
    #[Id(name: 'id')]
    public function category(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
 
    #[Get(route: FrontendRoute::item)]
    #[Id(name: 'id')]
    public function item(
        // Method parameters
    ): ResponseInterface
    {
        // Method implementation
    }
}
```

### Resulting Routes
Running yii router::register from the console will result in the following files in the `config/router` diectory:

#### groups.php
```php
<?php

declare(strict_types=1);

use Yiisoft\Router\Group;

return [
    Group::create()
        ->routes(...(require __DIR__ . '/routes/default.php'))
    ,
    Group::create('/admin')
        ->namePrefix('admin_')
        ->middleware('Loytyi\Auth\Middleware\IsLoggedIn')
        ->routes(...(require __DIR__ . '/routes/admin.php'))
    ,
];
```

#### /routes/admin.php
```php
?php

declare(strict_types=1);

use Yiisoft\Router\Route;

return [
    Route::methods(['GET'], '/categories')
        ->name('category_index')
        ->action([App\Admin\CategoryController::class, 'index'])
    ,
    Route::methods(['GET', 'POST'], '/category/create/{id:[1-9]\d*}')
        ->name('category_create')
        ->action([App\Admin\CategoryController::class, 'create'])
    ,
    Route::methods(['POST'], '/category/delete/{id:[1-9]\d*}')
        ->name('category_delete')
        ->action([App\Admin\CategoryController::class, 'delete'])
    ,
    Route::methods(['GET', 'POST'], '/category/update/{id:[1-9]\d*}')
        ->name('category_update')
        ->action([App\Admin\CategoryController::class, 'update'])
    ,
    Route::methods(['GET'], '/category/{id:[1-9]\d*}')
        ->name('category_view')
        ->action([App\Admin\CategoryController::class, 'view'])
    ,
    Route::methods(['GET'], '/items')
        ->name('item.index')
        ->action([App\Admin\ItemController::class, 'index'])
    ,
    Route::methods(['GET', 'POST'], '/item/create/{id:[1-9]\d*}')
        ->name('item.create')
        ->action([App\Admin\ItemController::class, 'create'])
    ,
    Route::methods(['POST'], '/item/delete/{id:[1-9]\d*}')
        ->name('item.delete')
        ->action([App\Admin\ItemController::class, 'delete'])
    ,
    Route::methods(['GET', 'POST'], '/item/update/{id:[1-9]\d*}')
        ->name('item.update')
        ->action([App\Admin\ItemController::class, 'update'])
    ,
    Route::methods(['GET'], '/item/{id:[1-9]\d*}')
        ->name('item.view')
        ->action([App\Admin\ItemController::class, 'view'])
    ,
];
```

>Note the difference between the Route names for the CategoryController where
> the Route enum defines route names and URIs directly, and the ItemController whose Route enum defines a prefix.
{style="note"}

#### /routes/default.php
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