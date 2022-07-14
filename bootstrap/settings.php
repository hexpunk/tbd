<?php

declare(strict_types=1);

use App\Env;
use App\Settings\AppSettings;
use App\Settings\LoggerSettings;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        Env::class => function () {
            return Env::getInstance();
        },
        AppSettings::class => function (Env $env) {
            return new AppSettings([
                'displayErrorDetails' => $env->get('DISPLAY_ERROR_DETAILS', false), // Should be set to false in production
                'logError'            => $env->get('LOG_ERROR', true),
                'logErrorDetails'     => $env->get('LOG_ERROR_DETAILS', false),
                'logger' => new LoggerSettings([
                    'name' => $env->get('APP_NAME', 'slim-app'),
                    'path' => $env->get('LOG_PATH', 'php://stdout'),
                    'level' => Logger::getLevels()[$env->get('LOG_LEVEL', 'DEBUG')],
                ]),
            ]);
        }
    ]);
};
