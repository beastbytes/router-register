# Route Enumeration

Routes in RouterRegister are defined using string backed
[enumerations](https://www.php.net/manual/en/language.enumerations.php)
that implement RouteInterface and use RouteTrait (both are part of the RouterRegister package).

Each route is a case where the name is the route name, 
and the string value is the URI.

If the URI has parameters, enclose each parameter name in braces.

If the route has optional parameters, define them in the URI as normal.  

> The URI is relative to the group it is in; do not include any group prefix.
{style="note"}

Defining routes this way means that there is a single point of truth in the application with all the benefits
that brings for code development and maintenance, and we get code completion in our IDE.

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

    case product_index = '/products';
    // with required parameter
    case product_category = '/products/{categoryId}';
    // with required parameter and optional parameter
    case product_view = '/product/{productId}[/{featureId}]';
}
```

## RouteInterface & RouteTrait
RouteInterface allows Routes to be type checked and defines two methods that can be used in your application:

```php
 // returns the route name
public function getName(): string;

 // returns the route URI. This will include parameter placeholders
public function getUri(): string;
```

RouteTrait implements RouteInterface.