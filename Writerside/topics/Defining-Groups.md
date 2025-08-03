# Defining Groups
Route Groups are defined in an [enumeration](https://www.php.net/manual/en/language.enumerations.php) 
that implements GroupInterface; GroupTrait provides an implementation of GroupInterface
(both are part of the RouterRegister package).

The enumeration cases are group names.

## Group Enumeration
For an application with a frontend and backend, with the backend in the `admin` group,
the enumeration will be: 

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

The frontend is in the `default` group and does not have route or name prefixes.

The default separator between the group and route name is `.` (dot). If a different separator is required, define the
`SEPARATOR` constant in the `RouteGroup` enumeration.

## GroupTrait
GroupTrait implements GroupInterface; it is used to generate routes and names in groups.

GroupTrait expose two methods:
* `getNamePrefix()` - returns the name prefix of the group
* `getPrefix()` - returns the route prefix of the group
> If prefix and/or namePrefix are defined by the `Group` attribute, the `Group` attribute values take precedence.
{style="note"}