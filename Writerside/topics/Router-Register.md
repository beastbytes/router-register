# RouterRegister

RouterRegister is a Yii console command package that allows routes to be defined in the application
source files using PHP Attributes. It generates router groups and routes configuration files from the attributes.

There are a number of benefits of defining and registering routes using RouterRegister:

* Self documenting code - it's clear that a method corresponds to a route and what parameters, hosts, middleware apply
to the route.
* Single point of truth - each route, it's URI and name, is defined in an enumeration, making maintenance simpler and 
provides IDE code completion.
* Simplifies development and eliminates typos - IDE code completion for routes works when generating URLs too.

RouterRegister supports grouping routes.

> RouterRegister does not currently support nested groups
{style="note"}

Using RouterRegister helps with generating URLs in application code as the IDE can provide code completion and checking.

## Installation

Install RouterRegister using [Composer](https://getcomposer.org/)

Add the following to the require-dev section of your composer.json:

```json
"beastbytes/router-register": "<version-constraint>",
```

or run

```PHP
php composer.phar require -dev "beastbytes/router-register:<version-constraint>"
```

## Usage
Using RouterRegister involves:
* [Configure the router](Yii-Router-Configuration.md)
* [Defining routes](Defining-Routes.md)
* [Defining groups](Defining-Groups.md) (if required)
* [Assigning groups and routes in source code](Assigning-Routes-and-Groups-in-Source-Code.md)
* [Run the Yii console command](Yii-Console-router-register-Command.md)
* [UrlGenerator](UrlGenerator.md)

> File watchers can automatically generate the groups and routes as you develop your application.