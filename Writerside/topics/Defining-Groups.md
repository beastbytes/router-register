# Defining Groups
Route Groups are defined in a string backed [enumeration](https://www.php.net/manual/en/language.enumerations.php) 
that implements GroupInterface; GroupTrait provides an implementation of GroupInterface
(both are part of the RouterRegister package).

The case name defines the group name prefix.

The case value defines the group prefix.

An application has zero or one Route Group enum.

## Group Enumeration
For an application with a frontend and backend, with the backend having the group prefix `admin`,
the enumeration will be: 

```php
<?php

declare(strict_types=1);

namespace App;

use BeastBytes\Router\Register\GroupInterface;
use BeastBytes\Router\Register\GroupTrait;

enum RouteGroup implements GroupInterface: string
{
    use GroupTrait;

    case backend => 'admin';
    case frontend => '';
}
```

Generated groups will be:
```php
<?php

declare(strict_types=1);

use Yiisoft\Router\Group;

return [
    Group::create()
        ->namePrefix('frontend.')
        ->routes(...(require __DIR__ . '/routes/frontend.php'))
    ,
    Group::create('/admin')
        ->namePrefix('backend.')
        ->routes(...(require __DIR__ . '/routes/backend.php'))
    ,
];
```

### Group Separator
The default separator between the group and route name is `.` (dot).
If a different separator is required, define the `SEPARATOR` public constant in the `RouteGroup` enumeration.

The following example defines the group separator as `_`.
```php
<?php

declare(strict_types=1);

namespace App;

use BeastBytes\Router\Register\GroupInterface;
use BeastBytes\Router\Register\GroupTrait;

enum RouteGroup implements GroupInterface: string
{
    use GroupTrait;
    
    public const SEPARATOR = '_';

    case backend => 'admin';
    case frontend => '';
}
```

Generated groups will be:
```php
<?php

declare(strict_types=1);

use Yiisoft\Router\Group;

return [
    Group::create()
        ->namePrefix('frontend_')
        ->routes(...(require __DIR__ . '/routes/frontend.php'))
    ,
    Group::create('/admin')
        ->namePrefix('backend_')
        ->routes(...(require __DIR__ . '/routes/backend.php'))
    ,
];
```

### Route Prefix
A common prefix for all groups can be defined by defining the `PREFIX` public constant in the `RouteGroup` enumeration.
This is used, for example, when the locale is defined in the path of the URL.

The example below defines a route prefix that defines the `locale` route parameter as two lower-case letters
(e.g. ISO-3166 Alpha-2 codes).
```php
<?php

declare(strict_types=1);

namespace App;

use BeastBytes\Router\Register\GroupInterface;
use BeastBytes\Router\Register\GroupTrait;

enum RouteGroup implements GroupInterface: string
{
    use GroupTrait;
    
    public const PREFIX = '{locale:[a-z]{2}}';

    case backend => 'admin';
    case frontend => '';
}
```

Generated groups will be:
```php
<?php

declare(strict_types=1);

use Yiisoft\Router\Group;

return [
    Group::create('/{locale:[a-z]{2}}')
        ->namePrefix('frontend.')
        ->routes(...(require __DIR__ . '/routes/frontend.php'))
    ,
    Group::create('{locale:[a-z]{2}}/admin')
        ->namePrefix('backend.')
        ->routes(...(require __DIR__ . '/routes/backend.php'))
    ,
];
```

## GroupTrait
GroupTrait implements GroupInterface; it generates routes, and route and name prefixes for groups.

GroupTrait expose two methods:
* `getNamePrefix()` - returns the name prefix of the group
* `getPrefix()` - returns the route prefix of the group
> If prefix and/or namePrefix are defined by the `Group` attribute, the `Group` attribute values take precedence.
{style="note"}