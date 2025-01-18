<?php

declare(strict_types=1);

use BeastBytes\Router\Routes\RoutesCommand;

return [
    'yiisoft/yii-console' => [
        'commands' => [
            'router:routes' => RoutesCommand::class,
        ],
    ],
];