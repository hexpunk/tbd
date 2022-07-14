<?php

declare(strict_types=1);

use App\Settings\AppSettings;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (AppSettings $settings) {
            $loggerSettings = $settings->logger;
            $logger = new Logger($loggerSettings->name);

            $logger->pushProcessor(new UidProcessor());
            $logger->pushHandler(new StreamHandler($loggerSettings->path, $loggerSettings->level));

            return $logger;
        },
    ]);
};
