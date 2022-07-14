<?php

declare(strict_types=1);

namespace App\Settings;

use App\Settings\AbstractSettings;
use App\Settings\LoggerSettings;

/**
 * @extends AbstractSettings<array{
 *   'displayErrorDetails': bool,
 *   'logError': bool,
 *   'logErrorDetails': bool,
 *   'logger': LoggerSettings,
 * }>
 * @property-read bool $displayErrorDetails
 * @property-read bool $logError
 * @property-read bool $logErrorDetails
 * @property-read LoggerSettings $logger
 */
class AppSettings extends AbstractSettings
{
}
