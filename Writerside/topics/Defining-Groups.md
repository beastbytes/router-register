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

The value of the constant is an array whose keys are integers or strings and values are strings
(`non-empty-array<int|string, string>`).
If the key is an integer the value is a string literal.
If the key is a string it is a parameter name and the value the corresponding pattern.

Array entries are prefixed to the route in the order defined.

The example below defines a route prefix that defines and literal and
the `locale` route parameter as two lower-case letters (e.g. ISO-3166 Alpha-2 codes).
```php
<?php

declare(strict_types=1);

namespace App;

use BeastBytes\Router\Register\GroupInterface;
use BeastBytes\Router\Register\GroupTrait;

enum RouteGroup implements GroupInterface: string
{
    use GroupTrait;
    
    public const PREFIX = [
        'example',
        'locale' => '[a-z]{2}'
    ];

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
    Group::create('/example/{locale:[a-z]{2}}')
        ->namePrefix('frontend.')
        ->routes(...(require __DIR__ . '/routes/frontend.php'))
    ,
    Group::create('/example/{locale:[a-z]{2}}/admin')
        ->namePrefix('backend.')
        ->routes(...(require __DIR__ . '/routes/backend.php'))
    ,
];
```

## GroupTrait
GroupTrait implements GroupInterface.