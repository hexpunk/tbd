<?php

declare(strict_types=1);

namespace App\Common;

use ArrayAccess;

class Map implements ArrayAccess
{
    public function __construct(private array $container = [])
    {
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->container[$offset] = $value;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->container[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    public function get(mixed $key, mixed $orElse = null): mixed
    {
        return isset($this[$key]) ? $this[$key] : $orElse;
    }
}
