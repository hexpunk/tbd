<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\FormatException;
use Symfony\Component\Dotenv\Exception\PathException;

class Env
{
    private static ?Env $instance = null;

    protected function __construct()
    {
        $dotenv = new Dotenv();

        try {
            $dotenv->loadEnv(__DIR__ . '/.env');
        } catch (PathException $ex) {
            trigger_error($ex->getMessage(), E_USER_WARNING);
        } catch (FormatException $ex) {
            trigger_error($ex->getMessage(), E_USER_ERROR);
        }
    }

    public static function getInstance(): Env
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @phpstan-template T
     * @phpstan-param T $orElse
     * @phpstan-return T
     */
    public function get(string $key, mixed $orElse = null): mixed
    {
        return isset($_ENV[$key]) ? $_ENV[$key] : $orElse;
    }
}
