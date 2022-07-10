<?php

declare(strict_types=1);

use App\Common\ImmutableMap;
use App\Env;
use App\Settings;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        Env::class => function () {
            return Env::getInstance();
        },
        Settings::class => function (Env $env) {
            $logLevelMap = new ImmutableMap(Logger::getLevels());

            return new Settings([
                'displayErrorDetails' => $env->get('DISPLAY_ERROR_DETAILS', false), // Should be set to false in production
                'logError'            => $env->get('LOG_ERROR', true),
                'logErrorDetails'     => $env->get('LOG_ERROR_DETAILS', false),
                'logger' => [
                    'name' => $env->get('APP_NAME', 'slim-app'),
                    'path' => $env->get('LOG_PATH', 'php://stdout'),
                    'level' => $logLevelMap->get($env->get('LOG_LEVEL'), 'DEBUG'),
                ],
            ]);
        }
    ]);
};
