<?php

declare(strict_types=1);

namespace App\Settings;

use App\Exceptions\NotImplementedException;

/**
 * @template T of array
 * @immutable
 */
abstract class AbstractSettings
{
    /**
     * @param T $settings
     */
    public function __construct(array $settings)
    {
        foreach ($settings as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
