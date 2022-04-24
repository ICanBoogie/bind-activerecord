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

use ICanBoogie\ActiveRecord;
use ICanBoogie\ActiveRecord\ActiveRecordCache\RuntimeActiveRecordCache;
use ICanBoogie\ActiveRecord\Connection;
use ICanBoogie\ActiveRecord\ConnectionCollection;
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\ModelCollection;
use ICanBoogie\Application;
use ICanBoogie\Validate\ValidationErrors;

final class Hooks
{
	/*
	 * Events
	 */

	/**
	 * Define model provider.
	 *
	 * Models are provided using the model collection bound to the application.
	 */
	static public function on_app_boot(Application\BootEvent $event, Application $app): void
	{
		ActiveRecord\ModelProvider::define(fn($id) => $app->models[$id]);
	}

	/*
	 * Prototypes
	 */

	static private function get_config(Application $app): Config
	{
		static $config;

		return $config ??= $app->configs['activerecord'];
	}

	/**
	 * Returns a @{link ConnectionCollection} instance configured with
	 * the `activerecord_connections` config.
	 */
	static public function app_lazy_get_connections(Application $app): ConnectionCollection
	{
		static $connections;

		return $connections ??= new ConnectionCollection(self::get_config($app)->connections);
	}

	/**
	 * Returns a @{link ModelCollection} instance configured with
	 * the `activerecord_models` config.
	 */
	static public function app_lazy_get_models(Application $app): ModelCollection
	{
		static $models;

		return $models ??= new ModelCollection($app->connections, self::get_config($app)->models);
	}

	/**
	 * Getter for the "primary" database connection.
	 */
	static public function app_lazy_get_db(Application $app): Connection
	{
		return $app->connections['primary'];
	}

	/**
	 * @return ValidationErrors|array
	 */
	static public function active_record_validate(ActiveRecord $record)
	{
		static $validate;

		$validate ??= new ActiveRecord\Validate\ValidateActiveRecord;

		return $validate($record);
	}

	/**
	 * Returns the records cache associated with the model.
	 */
	static public function model_lazy_get_activerecord_cache(Model $model): RuntimeActiveRecordCache
	{
		return new RuntimeActiveRecordCache($model);
	}
}
