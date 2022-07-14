<?php

declare(strict_types=1);

namespace App\Settings;

use App\Settings\AbstractSettings;

/**
 * @phpstan-import-type Level from \Monolog\Logger
 * @extends AbstractSettings<array{
 *   'name': string,
 *   'path': string,
 *   'level': Level,
 * }>
 * @property-read string $name
 * @property-read string $path
 * @property-read Level $level
 */
class LoggerSettings extends AbstractSettings
{
}
