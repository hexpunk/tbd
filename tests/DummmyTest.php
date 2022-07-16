<?php

declare(strict_types=1);

namespace Tests;

use Tests\TestCase;

class DummyTest extends TestCase
{
    public function testOneEqualsOne(): void
    {
        $this->assertEquals(1, 1);
    }

    public function testArrayIsArray(): void
    {
        $this->assertIsArray([]);
    }
}
