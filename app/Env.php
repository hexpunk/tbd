<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

class Env
{
    public function __construct(callable | null $func)
    {
        $dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
        if ($func) {
            $func($dotenv);
        }
        $dotenv->safeLoad();
    }

    public function get(string $key, mixed $orElse = null): mixed
    {
        return getenv($key) ?: $orElse;
    }
}
