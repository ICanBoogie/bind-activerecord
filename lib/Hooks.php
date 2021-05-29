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
use ICanBoogie\ActiveRecord\Connection;
use ICanBoogie\ActiveRecord\ConnectionCollection;
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\ModelCollection;
use ICanBoogie\ActiveRecord\ActiveRecordCache\RuntimeActiveRecordCache;
use ICanBoogie\Application;
use ICanBoogie\Validate\ValidationErrors;

final class Hooks
{
	/**
	 * Synthesizes a config from a namespace.
	 *
	 * The config fragments found in the namespace are merged with `array_merge()`.
	 *
	 * @param array<string, array> $fragments
	 *
	 * @return array<string, mixed>
	 */
	static private function synthesize_config_from_namespace(array $fragments, string $namespace): array
	{
		$config = [];

		foreach ($fragments as $fragment)
		{
			if (empty($fragment[$namespace]))
			{
				continue;
			}

			$config[] = $fragment[$namespace];
		}

		return $config ? array_merge(...$config) : [];
	}

	/**
	 * Synthesizes the `activerecord_connections` config from `activerecord#connections` fragments.
	 *
	 * @param array<string, array> $fragments
	 *
	 * @return array<string, mixed>
	 */
	static public function synthesize_connections_config(array $fragments): array
	{
		return self::synthesize_config_from_namespace($fragments, 'connections');
	}

	/**
	 * Synthesizes the `activerecord_models` config from `activerecord#models` fragments.
	 *
	 * @param array<string, array> $fragments
	 *
	 * @return array<string, mixed>
	 */
	static public function synthesize_models_config(array $fragments): array
	{
		return self::synthesize_config_from_namespace($fragments, 'models');
	}

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
		ActiveRecord\ModelProvider::define(function($id) use ($app) {

			return $app->models[$id];

		});
	}

	/*
	 * Prototypes
	 */

	/**
	 * Returns a @{link ConnectionCollection} instance configured with
	 * the `activerecord_connections` config.
	 */
	static public function app_lazy_get_connections(Application $app): ConnectionCollection
	{
		static $connections;

		return $connections
			?? $connections = new ConnectionCollection($app->configs['activerecord_connections'] ?? []);
	}

	/**
	 * Returns a @{link ModelCollection} instance configured with
	 * the `activerecord_models` config.
	 */
	static public function app_lazy_get_models(Application $app): ModelCollection
	{
		static $models;

		return $models
			?? $models = new ModelCollection($app->connections, $app->configs['activerecord_models'] ?? []);
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

		if (!$validate)
		{
			$validate = new ActiveRecord\Validate\ValidateActiveRecord;
		}

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
