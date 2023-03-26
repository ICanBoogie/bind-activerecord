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

use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\ConfigBuilder;
use ICanBoogie\ActiveRecord\SchemaBuilder;
use PHPUnit\Framework\TestCase;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Article;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Node;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\NodeModel;

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
                'primary' => new Config\ConnectionDefinition(
                    id: 'primary',
                    dsn: 'mysql:dbname=myblog;host=mysql5-20',
                    username: "olvlvl",
                    password: "p455w0rd",
                    table_name_prefix: 'myblog_',
                    charset_and_collate: 'bin/general_ci',
                    time_zone: '+02:00',
                )
            ], []),
            $config
        );
    }

    public function test_integration(): void
    {
        $expected = (new ConfigBuilder())
            ->add_connection(Config::DEFAULT_CONNECTION_ID, 'sqlite::memory:')
            ->add_connection('cache', 'sqlite::memory:')
            ->add_model(
                id: 'nodes',
                activerecord_class: Node::class,
                model_class: NodeModel::class,
                schema_builder: fn(SchemaBuilder $b) => $b
                    ->add_serial('id', primary: true)
                    ->add_character('title'),
            )
            ->add_model(
                id: 'articles',
                activerecord_class: Article::class,
                extends: 'nodes',
                schema_builder: fn(SchemaBuilder $b) => $b
                    ->add_text('body')
                    ->add_datetime('date'),
            )
            ->build();

        $actual = app()->configs->config_for_class(Config::class);

        $this->assertEquals(
            $expected,
            $actual
        );
    }
}
