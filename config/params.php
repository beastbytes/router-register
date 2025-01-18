<?php

declare(strict_types=1);

use BeastBytes\Router\Routes\RegisterCommand;

return [
    'yiisoft/yii-console' => [
        'commands' => [
            'router:register' => RegisterCommand::class,
        ],
    ],
];