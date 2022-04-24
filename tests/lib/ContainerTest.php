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

use ICanBoogie\ActiveRecord\ConnectionProvider;
use ICanBoogie\ActiveRecord\ModelProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

use function ICanBoogie\app;

final class ContainerTest extends TestCase
{
    private ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = app()->container->get('service_container');
    }

    /**
     * @dataProvider provide_service
     */
    public function test_service(string $id, string $expected_class): void
    {
        $this->assertInstanceOf($expected_class, $this->container->get($id));
    }

    public function provide_service(): array
    {
        return [

            [ 'test.active_record.connections', ConnectionProvider::class ],
            [ 'test.active_record.models', ModelProvider::class ],

        ];
    }
}
