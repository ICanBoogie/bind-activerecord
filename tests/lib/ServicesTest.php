<?php

namespace Test\ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\StaticModelProvider;
use ICanBoogie\Application\BootEvent;
use PHPUnit\Framework\TestCase;

final class ServicesTest extends TestCase
{
    /**
     * Asserts {@link BootEvent} was leveraged to configure the static model provider.
     */
    public function test_get_model_provider(): void
    {
        $this->assertNotNull(StaticModelProvider::get());
    }
}
