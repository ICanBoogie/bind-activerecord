<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\ActiveRecordCache;
use ICanBoogie\ActiveRecord\Connection;
use ICanBoogie\ActiveRecord\ConnectionCollection;
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\ModelCollection;
use ICanBoogie\Application;
use ICanBoogie\Validate\ValidationErrors;

use function ICanBoogie\app;
use function ICanBoogie\ActiveRecord\get_model;
use PHPUnit\Framework\TestCase;

class HooksTest extends TestCase
{
	/**
	 * @var Application
	 */
	static private $app;

	static public function setupBeforeClass(): void
	{
		self::$app = app();
	}

	public function test_should_return_activerecord_connections_config()
	{
		$config = Hooks::synthesize_connections_config(self::$app->configs->get_fragments('activerecord'));

		$this->assertNotEmpty($config);
		$this->assertEquals([

			'primary' => 'sqlite::memory:',
			'cache' => 'sqlite::memory:'

		], $config);

		$this->assertEquals($config, self::$app->configs['activerecord_connections']);
	}

	public function test_should_return_activerecord_models_config()
	{
		$config = Hooks::synthesize_models_config(self::$app->configs->get_fragments('activerecord'));

		$this->assertNotEmpty($config);
		$this->assertEquals([ 'nodes', 'articles' ], array_keys($config));
		$this->assertEquals($config, self::$app->configs['activerecord_models']);
	}

	public function test_should_return_connection_collection()
	{
		$app = self::$app;
		$connections = Hooks::app_lazy_get_connections($app);

		$this->assertInstanceOf(ConnectionCollection::class, $connections);
		$this->assertInstanceOf(ConnectionCollection::class, $app->connections);
		$this->assertSame($connections, self::$app->connections);
	}

	public function test_should_return_primary_connection()
	{
		$app = self::$app;
		$db = Hooks::app_lazy_get_db($app);

		$this->assertInstanceOf(Connection::class, $db);
		$this->assertInstanceOf(Connection::class, $app->db);
		$this->assertSame($db, self::$app->db);
	}

	public function test_should_return_model_collection()
	{
		$app = self::$app;
		$models = Hooks::app_lazy_get_models($app);

		$this->assertInstanceOf(ModelCollection::class, $models);
		$this->assertInstanceOf(ModelCollection::class, $app->models);
		$this->assertSame($models, self::$app->models);
	}

	/**
	 * @depends test_should_return_primary_connection
	 */
	public function test_should_return_activerecord_cache()
	{
		$models = $this
			->getMockBuilder(ModelCollection::class)
			->disableOriginalConstructor()
			->getMock();

		/* @var $models ModelCollection */

		$model = new Model($models, [

			Model::CONNECTION => self::$app->db,
			Model::NAME => 'model' . uniqid(),
			Model::SCHEMA => [

				'id' => 'serial'

			]
		]);

		$cache = Hooks::model_lazy_get_activerecord_cache($model);
		$this->assertInstanceOf(ActiveRecordCache::class, $cache);
		$this->assertInstanceOf(ActiveRecordCache::class, $model->activerecord_cache);
	}

	public function test_should_patch_get_model()
	{
		$model_id = uniqid();
		$model = $this
			->getMockBuilder(Model::class)
			->disableOriginalConstructor()
			->getMock();

		$models = $this
			->getMockBuilder(ModelCollection::class)
			->disableOriginalConstructor()
			->setMethods([ 'offsetGet' ])
			->getMock();
		$models
			->expects($this->once())
			->method('offsetGet')
			->with($model_id)
			->willReturn($model);

		$app = $this
			->getMockBuilder(Application::class)
			->disableOriginalConstructor()
			->setMethods([ 'lazy_get_models '])
			->getMock();

		$event = Application\BootEvent::from([ 'target' => $app ]);

		/* @var $event Application\BootEvent */
		/* @var $app Application */

		$app->models = $models;

		Hooks::on_app_boot($event, $app);

		$this->assertSame($model, get_model($model_id));
	}

	public function test_active_record_validate()
	{
		$record = new SampleRecord;

		$this->assertInstanceOf(ValidationErrors::class, Hooks::active_record_validate($record));
	}
}
