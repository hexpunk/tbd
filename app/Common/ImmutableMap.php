<?php

declare(strict_types=1);

namespace App\Common;

use App\Common\Map;
use App\Exceptions\NotImplementedException;

class ImmutableMap extends Map
{
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new NotImplementedException();
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new NotImplementedException();
    }
}
