# Yii Console router::register Command

## NAME
router::register - Register routes to configuration

## SYNOPSIS
php yii router:register [OPTION]... [SRC]

## DESCRIPTION
Registers routes defined by PHP attributes in application source files to router configuration files.

## ARGUMENT
Path to source files. All directories in the path are scanned. [default: current working directory]

## OPTIONS
-d, --default-group[=DEFAULT-GROUP]<br/>
Default group name. [default: "default"]

-e, --except[=EXCEPT]<br/>
Exclude path from source files. (multiple values allowed)<br/>
[default: ['./config/\**', './resources/\**', './tests/\**', './vendor/\**']]

-o, --only[=ONLY]<br/>
Use the Only specified pattern for matching source files. (multiple values allowed)<br/>
[default: ['\**Controller.php']]

-w, --write[=WRITE]<br/>
Path to Write router configuration files to.<br/>
[default: "./config/router"]

> The standard Yii console options are also available

## EXAMPLES
```php
php yii router::register
```
Register routes using all default options

```php
php yii router::register -d frontend
```
Register routes using 'frontend' as the default group

```php
php yii router::register -w ./router
```
Register routes and write configuration files to ./route directory

