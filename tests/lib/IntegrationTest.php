<?php

namespace Test\ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\ModelProvider;
use PHPUnit\Framework\TestCase;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\NodeModel;

use function ICanBoogie\app;

final class IntegrationTest extends TestCase
{
    public function test_nodes_model(): void
    {
        $model_provider = app()->service_for_id('test.active_record.models', ModelProvider::class);
        $nodes = $model_provider->model_for_id('nodes');

        $this->assertInstanceOf(NodeModel::class, $nodes);
        $this->assertEquals('id', $nodes->schema->primary);
        $this->assertEquals('id', $nodes->primary);
    }
}
