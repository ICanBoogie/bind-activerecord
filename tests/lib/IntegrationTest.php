<?php

namespace Test\ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\ModelProvider;
use PHPUnit\Framework\TestCase;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Article;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Node;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\NodeModel;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\SampleService;

use function ICanBoogie\app;

final class IntegrationTest extends TestCase
{
    public function test_nodes_model(): void
    {
        $model_provider = app()->service_for_id('test.active_record.models', ModelProvider::class);
        $nodes = $model_provider->model_for_record(Node::class);

        $this->assertInstanceOf(NodeModel::class, $nodes);
        $this->assertEquals('id', $nodes->schema->primary);
        $this->assertEquals('id', $nodes->primary);
    }

    public function test_qualified_model(): void
    {
        $service = app()->service_for_class(SampleService::class);
        $actual = $service->model->activerecord_class;

        $this->assertEquals(Article::class, $actual);
    }
}
