<?php

declare(strict_types=1);

namespace App;

use App\Common\ImmutableMap;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\FormatException;
use Symfony\Component\Dotenv\Exception\PathException;

class Env extends ImmutableMap
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

        parent::__construct($_ENV);
    }

    public static function getInstance(): Env
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
