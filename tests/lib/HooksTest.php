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
use ICanBoogie\ActiveRecord\Connection;
use ICanBoogie\ActiveRecord\ConnectionCollection;
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\ModelCollection;
use ICanBoogie\ActiveRecord\Schema;
use ICanBoogie\ActiveRecord\SchemaColumn;
use ICanBoogie\Binding\ActiveRecord\Hooks;
use ICanBoogie\Validate\ValidationErrors;
use PHPUnit\Framework\TestCase;

use function ICanBoogie\app;

final class HooksTest extends TestCase
{
    public function test_should_return_connection_collection(): void
    {
        $app = app();
        $connections = Hooks::app_get_connections($app);

        $this->assertInstanceOf(ConnectionCollection::class, $connections);
        $this->assertInstanceOf(ConnectionCollection::class, $app->connections);
        $this->assertSame($connections, app()->connections);
    }

    public function test_should_return_primary_connection(): void
    {
        $app = app();
        $db = Hooks::app_get_db($app);

        $this->assertInstanceOf(Connection::class, $db);
        $this->assertInstanceOf(Connection::class, $app->db);
        $this->assertSame($db, app()->db);
    }

    public function test_should_return_model_collection(): void
    {
        $app = app();
        $models = Hooks::app_get_models($app);

        $this->assertInstanceOf(ModelCollection::class, $models);
        $this->assertInstanceOf(ModelCollection::class, $app->models);
        $this->assertSame($models, app()->models);
    }

    /**
     * @depends test_should_return_primary_connection
     */
    public function test_should_return_activerecord_cache(): void
    {
        $models = $this
            ->getMockBuilder(ModelCollection::class)
            ->disableOriginalConstructor()
            ->getMock();

        /* @var $models ModelCollection */

        $model = new Model($models, [

            Model::CONNECTION => app()->db,
            Model::NAME => 'model' . uniqid(),
            Model::SCHEMA => new Schema([
                'id' => SchemaColumn::serial()
            ])
        ]);

        $cache = Hooks::model_lazy_get_activerecord_cache($model);
        $this->assertInstanceOf(ActiveRecordCache::class, $cache);
        $this->assertInstanceOf(ActiveRecordCache::class, $model->activerecord_cache);
    }

    public function test_get_models(): void
    {
        $models = Hooks::app_get_models(app());

        $this->assertTrue(isset($models['nodes']));
        $this->assertTrue(isset($models['articles']));

        $this->assertSame($models, app()->models);
    }

    public function test_active_record_validate(): void
    {
        $record = new SampleRecord();

        $this->assertInstanceOf(ValidationErrors::class, Hooks::active_record_validate($record));
    }
}
