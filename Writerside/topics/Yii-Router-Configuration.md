# Yii Router Configuration

RouterRegister generates group and route configuration files for use by the Router. 
To use them in your configuration simply require and unpack the groups.php file in the ```AddGroup()``` method of your
route collector; the RouteCollectionInterface configuration should look something like:

```php
    RouteCollectionInterface::class => static function (
        RouteCollectorInterface $collector
    ) {
        $collector
            ->middleware(CsrfTokenMiddleware::class)
            ->middleware(FormatDataResponse::class)
            // adjust according to fit your directory structure
            ->addGroup(...(require dirname(__DIR__, 2)
                . DIRECTORY_SEPARATOR . 'router'
                . DIRECTORY_SEPARATOR . 'groups.php'
            ))
        ;

        return new RouteCollection($collector);
    },
```