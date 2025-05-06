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

## GroupTrait

GroupTrait implements GroupInterface and so defines three methods: `getName()`, `getPrefix()` and `getNamePrefix()`
that return the group name, and the group name prefixed with '/' and suffixed with '_' respectively.

For example, the Route Group definition above returns the following:
* `getName()` => 'admin'
* `getPrefix()` => '/admin'
* `getNamePrefix()` => 'admin_'

> If prefix and/or namePrefix are defined by the `Group` attribute, the `Group` attribute values take precedence.
{style="note"}