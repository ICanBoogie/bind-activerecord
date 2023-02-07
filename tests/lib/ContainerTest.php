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

use ICanBoogie\ActiveRecord\Connection;
use ICanBoogie\ActiveRecord\ConnectionProvider;
use ICanBoogie\ActiveRecord\ModelProvider;
use ICanBoogie\Binding\ActiveRecord\Config;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use function ICanBoogie\app;

final class ContainerTest extends TestCase
{
    private ContainerInterface $container;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function setUp(): void
    {
        parent::setUp();

        // @phpstan-ignore-next-line
        $this->container = app()->container->get('service_container');
    }

    /**
     * @dataProvider provide_service
     *
     * @param class-string $expected_class
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function test_service(string $id, string $expected_class): void
    {
        $this->assertInstanceOf($expected_class, $this->container->get($id));
    }

    // @phpstan-ignore-next-line
    public function provide_service(): array
    {
        return [

            [ 'test.active_record.config', Config::class ],
            [ 'test.active_record.connections', ConnectionProvider::class ],
            [ 'test.active_record.models', ModelProvider::class ],
            [ 'active_record.connection.primary', Connection::class ],
            [ 'active_record.connection.cache', Connection::class ],
            [ 'test.active_record.model.node_by_class', NodeModel::class ],
            [ 'test.active_record.model.node_by_id', NodeModel::class ],

        ];
    }
}
