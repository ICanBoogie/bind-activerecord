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

use ICanBoogie\ActiveRecord\ActiveRecordCache;
use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\ConnectionProvider;
use ICanBoogie\ActiveRecord\ModelCollection;
use ICanBoogie\ActiveRecord\SchemaBuilder;
use ICanBoogie\Binding\ActiveRecord\Hooks;
use ICanBoogie\Validate\ValidationErrors;
use PHPUnit\Framework\TestCase;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\NodeModel;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\SampleRecord;

use function ICanBoogie\app;

final class HooksTest extends TestCase
{
    public function test_should_return_activerecord_cache(): void
    {
        $models = $this
            ->getMockBuilder(ModelCollection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $connection = app()
            ->service_for_class(ConnectionProvider::class)
            ->connection_for_id(Config::DEFAULT_CONNECTION_ID);

        $model = new NodeModel(
            $connection,
            $models,
            new Config\ModelDefinition(
                id: 'nodes',
                connection: Config::DEFAULT_CONNECTION_ID,
                schema: (new SchemaBuilder())
                    ->add_serial('id', primary: true)
                    ->build(),
                model_class: NodeModel::class,
                name: 'nodes'
            )
        );

        $cache = Hooks::model_lazy_get_activerecord_cache($model);
        $this->assertInstanceOf(ActiveRecordCache::class, $cache);
        $this->assertInstanceOf(ActiveRecordCache::class, $model->activerecord_cache);
    }

    public function test_active_record_validate(): void
    {
        $record = new SampleRecord();

        $this->assertInstanceOf(ValidationErrors::class, Hooks::active_record_validate($record));
    }
}
