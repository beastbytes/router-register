# RouterRegister

RouterRegister is a Yii console command package that allows routes to be defined using PHP Attributes in the application
source files. It generates router groups and routes configuration files from the attributes.

There are a number of benefits of defining and registering routes using RouterRegister:

* Self documenting code - it's clear that a method corresponds to a route and what parameters, hosts, middleware applies
to the route.
* Single point of truth - each route, it's URI and name, is defined in an enumeration, making maintenance simpler and 
provides IDE code completion.
* Simplifies development and eliminates typos - IDE code completion for routes works when generating URLs too.

RouterRegister supports grouping routes.

> RouterRegister does not currently support nested groups
{style="note"}

File watchers can automatically update the router configuration as you develop your application.

## Installation

Install RouterRegister using [Composer](https://getcomposer.org/)

Add the following to the require-dev section of your composer.json:

```json
"beastbytes/router-register": "*",
```

or run

```PHP
php composer.phar require -dev "beastbytes/router-register:*"
```

## Usage
Using RouterRegister involves:
* Defining routes in Route enumerations
* Adding Attributes to source code
* Running the Yii console command 
