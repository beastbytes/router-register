# Defining Routes
Routes are defined using string-backed [enumerations](https://www.php.net/manual/en/language.enumerations.php)
that implement RouteInterface; RouteTrait provides an implementation of RouteTrait
(both are part of the RouterRegister package).

Each route is a case where the name is the route name, and the string value is the URI.

If the URI has parameters, enclose each parameter name in braces.

If the route has optional parameters, define them in the URI as normal.

> The URI is relative to the group it is in; do not include any group prefix.
{style="note"}

Defining routes this way means that there is a single point of truth in the application with all the benefits
that brings for code development and maintenance, and we get code completion in our IDE.

## Route Prefix
A Route enum can define a `public constant PREFIX`. The value of this constant is used as the prefix
for all route names. Example: if the prefix is `product`,
the route name for the case `view` is `product.view`. The separator can be changed by setting
the `public constant SEPARATOR`.

By default, the prefix also applies to the route URI. Example: if the prefix is `product`,
the URI for `case view = /{productId};` is `/product/{productId}`.
This behaviour can be overridden by starting the URI (case value) with `//`.
Example: the URI for `case index = //products;` is `/products`.

## Route Enumeration Example
Our application shows products to users using the ProductController. We define a ProductRoute enumeration
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
    
    public const PREFIX = 'product';

    case index = '//products';
    // with required parameter
    case category = '//products/{categoryId}';
    // with required parameter and optional parameter
    case view = '/{productId}[/{featureId}]';
}
```

## RouteInterface & RouteTrait
RouteInterface allows Routes to be type-checked and defines the `getRouteName()` method
that can be used in the application for generating URLs.

RouteTrait implements RouteInterface.