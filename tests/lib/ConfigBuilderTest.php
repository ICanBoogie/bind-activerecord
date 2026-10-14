<?php

namespace Test\ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\ConfigBuilder;
use PHPUnit\Framework\TestCase;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Article;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Node;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\NodeModel;

use function ICanBoogie\app;

final class ConfigBuilderTest extends TestCase
{
    public function test_integration(): void
    {
        $expected = new ConfigBuilder()
            ->add_connection(Config::DEFAULT_CONNECTION_ID, 'sqlite::memory:')
            ->add_connection('cache', 'sqlite::memory:')
            ->add_record(Node::class, model_class: NodeModel::class)
            ->add_record(Article::class)
            ->build();

        $actual = app()->configs->config_for_class(Config::class);

        $this->assertEquals(
            $expected,
            $actual
        );
    }
}
