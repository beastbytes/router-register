# UrlGenerator
RouterRegister helps with Url generation as URL name generation gets code completion and checking from the IDE.

## Setting Up Url Name Generation
Generated URL names have the format `group.prefix.name` where:

* `group` - optional - the name of the group the route belongs to
* `prefix` - optional - route prefix
* `name` route name

### Defining the Group
To generate route names for routes in a given group, define `private const GROUP` in the route enum.
This can be defined using the Group enum.

The example below defines the RouteGroup enum,
and the AppRoute enum will generate route names in the `backend` group.

```php
<?php

declare(strict_types=1);

namespace App;

use BeastBytes\Router\Register\Route\GroupInterface;
use BeastBytes\Router\Register\Route\GroupTrait;

enum RouteGroup implements GroupInterface
{
    use GroupTrait;

    case backend = 'admin';
    case frontend = '';
}
```

```php
<?php

declare(strict_types=1);

namespace App\Backend;

use App\RouteGroup;
use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Route\RouteTrait;

enum AppRoute: string implements RouteInterface
{
    use RouteTrait;
    
    private const GROUP = RouteGroup::backend;

    case dashboard => '/';
}
```

### Defining the Prefix
To generate route names with a common prefix, define `public const PREFIX` in the route enum.

The example below will generate route names in the `backend` group with the prefix `item`.

```php
<?php

declare(strict_types=1);

namespace App\Admin\Item;

use App\RouteGroup;
use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Route\RouteTrait;

enum ItemRoute: string implements RouteInterface
{
    use RouteTrait;
    
    public const PREFIX = 'item';
    private const GROUP = RouteGroup::backend;

    case index => '/items';
    case create => '/item/create';
    case delete => '/item/delete/{id}';
    case update => '/item/update/{id}';
    case view => '/item/{id}';
}
```

### Defining the Separator
The default separator is dot(.). To define a different separator, define `private const SEPARATOR`
with the required separator in route enums.
The simplest way to do this is to define a trait in the application that uses RouterRegister's RouteTrait
and defines the SEPARATOR constant, and use that trait in the route enums.

The example below will generate route names in the `backend` group, with the prefix `item`,
and underscore(_) as the separator; e.g. `backend_item_index`.
```php
<?php

declare(strict_types=1);

namespace App;

trait RouteTrait {
    use BeastBytes\Router\Register\RouteTrait;
    
    private const SEPARATOR = '_';
}
```

```php
<?php

declare(strict_types=1);

namespace App\Admin\Item;

use App\RouteGroup;
use App\RouteTrait;
use BeastBytes\Router\Register\Route\RouteInterface;

enum ItemRoute: string implements RouteInterface
{
    use RouteTrait;
    
    public const PREFIX = 'item';
    private const GROUP = RouteGroup::backend;

    case index => '/items';
    case create => '/item/create';
    case delete => '/item/delete/{id}';
    case update => '/item/update/{id}';
    case view => '/item/{id}';
}
```

### Example Route Names
* `backend.dashboard` - group.name
* `backend.product.index` - group.prefix.name
* `product.view` - prefix.name
* `login` - name

## Generating URLs
URL names are generated using Route enums by calling the `getRouteName()` method;
this is then passed as the `name` parameter to `UrlGeneratorInterface::generate()`,
e.g.
```php
$url = $urlGenerator->generate(ItemRoute::view->getRouteName(), ['id' => $item->getId()]);
```