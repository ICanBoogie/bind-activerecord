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

use ICanBoogie\ActiveRecord\ConnectionOptions;
use ICanBoogie\ActiveRecord\Schema;
use ICanBoogie\ActiveRecord\SchemaColumn;
use ICanBoogie\Binding\ActiveRecord\Config;
use ICanBoogie\Binding\ActiveRecord\ConfigBuilder;
use PHPUnit\Framework\TestCase;

use function ICanBoogie\app;

final class ConfigBuilderTest extends TestCase
{
    public function test_build(): void
    {
        $config = (new ConfigBuilder())
            ->add_connection(
                id: 'primary',
                dsn: 'mysql:dbname=myblog;host=mysql5-20',
                username: "olvlvl",
                password: "p455w0rd",
                table_name_prefix: 'myblog_',
                charset_and_collate: 'bin/general_ci',
                time_zone: '+02:00'
            )->build();

        $this->assertEquals(
            new Config([
                'primary' => [
                    'dsn' => 'mysql:dbname=myblog;host=mysql5-20',
                    'username' => "olvlvl",
                    'password' => "p455w0rd",
                    'options' => [
                        ConnectionOptions::ID => 'primary',
                        ConnectionOptions::TABLE_NAME_PREFIX => 'myblog_',
                        ConnectionOptions::CHARSET_AND_COLLATE => 'bin/general_ci',
                        ConnectionOptions::TIMEZONE => '+02:00',
                    ]
                ]
            ], []),
            $config
        );
    }

    public function test_integration(): void
    {
        $this->assertEquals(
            new Config(
                [
                    'primary' => [
                        'dsn' => 'sqlite::memory:',
                        'options' => [
                            '#id' => 'primary',
                            '#charset_and_collate' => 'utf8/general_ci',
                            '#timezone' => '+00:00',
                        ],
                    ],
                    'cache' => [
                        'dsn' => 'sqlite::memory:',
                        'options' => [
                            '#id' => 'cache',
                                '#charset_and_collate' => 'utf8/general_ci',
                            '#timezone' => '+00:00',
                        ],
                    ],
                ],
                [
                    'nodes' => [
                        'schema' => new Schema([
                            'id' => SchemaColumn::serial(),
                            'title' => SchemaColumn::varchar(),
                        ]),
                        'connection' => 'primary',
                        'id' => 'nodes',
                    ],
                    'articles' => [
                        'schema' => new Schema([
                            'body' => SchemaColumn::text(),
                            'date' => SchemaColumn::datetime(),
                        ]),
                        'connection' => 'primary',
                        'id' => 'articles',
                    ],
                ]
            ),
            app()->configs['activerecord']
        );
    }
}
