<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\StaticModelProvider;
use PHPUnit\Framework\TestCase;

final class ServicesTest extends TestCase
{
    /**
     * Troubleshoot: config/event.php
     */
    public function test_get_models(): void
    {
        $this->assertNotNull(StaticModelProvider::defined());
    }
}
