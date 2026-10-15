<?php

namespace Test\ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\StaticModelProvider;
use ICanBoogie\Binding\ActiveRecord\Boot;
use PHPUnit\Framework\TestCase;

final class ServicesTest extends TestCase
{
    /**
     * Asserts {@see Boot} was leveraged to configure the static model provider.
     */
    public function test_get_model_provider(): void
    {
        $this->assertNotNull(StaticModelProvider::get());
    }
}
