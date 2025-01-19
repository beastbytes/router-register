# Route Enumeration

Routes in RouterRegister are defined using string backed
[enumerations](https://www.php.net/manual/en/language.enumerations.php)
that implement RouteInterface and use RouteTrait (both are part of the RouterRegister package).

Each route is a case where the name is the route name
and the string value is the URI.

If the URI has parameters enclose each parameter name in braces.

> The URI is relative to the group it is in; do not include any group prefix.
{style="note"}

Defining routes this way means that there is a single point of truth in the application with all the benefits
that brings for code maintenance, and we get code completion in our IDE.

## Route Enumeration Example
Our application has a unique product  that is managed using the productController. We define a productRoute enumeration
that defines the routes and provides them to the application.

```php
<?php

declare(strict_types=1);

namespace App\Product;

use BeastBytes\Router\Register\RouteInterface;
use BeastBytes\Router\Register\RouteTrait;

enum ProductRoute: string implements RouteInterface
{
    use RouteTrait;

    case product_index = '/products';
    case product_view = '/product/{productId}';
}
```