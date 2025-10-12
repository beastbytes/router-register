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
A Route enum can define `public constant PREFIX`. The value of this constant is used as the prefix
for all route names. Example: if the prefix is `product`,
the route name for the case `view` is `product.view`. The separator can be changed by setting
the `public constant SEPARATOR`.

By default, the prefix also applies to the route URI. Example: if the prefix is `product`,
the URI for `case view = /{productId};` is `/product/{productId}`.
This behaviour can be overridden by starting the URI (case value) with `//`.
Example: the URI for `case index = //products;` is `/products`.

## Route Group
If the application groups routes Route enums must define `public constant GROUP` whose value is a RouteGroup enum.
Example: `public constant GROUP = RouteGroup::frontend` denotes that the route is in the `frontend` group.
For `case view = /{productId}`
with `public constant GROUP = RouteGroup::frontend`
and `public constant PREFIX = product`
the resulting route name is `frontend.product.view`.

## Route Enumeration Example
Our application shows products to users using the ProductController. We define a ProductRoute enumeration
that defines the routes and provides them to the application.

```php
<?php

declare(strict_types=1);

namespace App\Product;

use App\RouteGroup;
use BeastBytes\Router\Register\Route\RouteInterface;
use BeastBytes\Router\Register\Route\RouteTrait;

enum ProductRoute: string implements RouteInterface
{
    use RouteTrait;
    
    public const GROUP = RouteGroup::frontent;
    public const PREFIX = 'product';

    case index = '//products';
    // with required parameter
    case category = '//products/{categoryId}';
    // with required parameter and optional parameter
    case view = '/{productId}[/{featureId}]';
}
```

## RouteInterface & RouteTrait
RouteInterface defines methods when generating URLs in the application.

RouteTrait implements RouteInterface.

Use RouteTrait in application Route enums.