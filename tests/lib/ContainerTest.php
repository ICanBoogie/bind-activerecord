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
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\ModelProvider;
use ICanBoogie\ActiveRecord\Config;
use PHPUnit\Framework\TestCase;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\NodeModel;

use function ICanBoogie\app;

final class ContainerTest extends TestCase
{
    /**
     * @dataProvider provide_service
     *
     * @param class-string $expected_class
     */
    public function test_service(string $id, string $expected_class): void
    {
        $this->assertInstanceOf($expected_class, app()->service_for_id($id, $expected_class));
    }

    /**
     * @return array<array{ 0: string, 1: class-string }>
     */
    public function provide_service(): array
    {
        return [

            [ 'test.active_record.config', Config::class ],
            [ 'test.active_record.connections', ConnectionProvider::class ],
            [ 'test.active_record.models', ModelProvider::class ],
            [ 'test.active_record.model.node_by_class', NodeModel::class ],
            [ 'test.active_record.model.node_by_id', NodeModel::class ],
            [ 'active_record.connection.primary', Connection::class ],
            [ 'active_record.connection.cache', Connection::class ],
            [ 'active_record.model.articles', Model::class ],

        ];
    }
}
