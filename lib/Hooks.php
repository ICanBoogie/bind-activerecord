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
use ICanBoogie\Core;
use ICanBoogie\Validate\ValidationErrors;

class Hooks
{
	/**
	 * Synthesizes a config from a namespace.
	 *
	 * The config fragments found in the namespace are merged with `array_merge()`.
	 *
	 * @param array $fragments
	 * @param string $namespace
	 *
	 * @return array
	 */
	static private function synthesize_config_from_namespace(array $fragments, $namespace)
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

		return $config ? call_user_func_array('array_merge', $config) : [];
	}

	/**
	 * Synthesizes the `activerecord_connections` config from `activerecord#connections` fragments.
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	static public function synthesize_connections_config(array $fragments)
	{
		return self::synthesize_config_from_namespace($fragments, 'connections');
	}

	/**
	 * Synthesizes the `activerecord_models` config from `activerecord#models` fragments.
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	static public function synthesize_models_config(array $fragments)
	{
		return self::synthesize_config_from_namespace($fragments, 'models');
	}

	/*
	 * Events
	 */

	/**
	 * Patches the `get_model()` helper to use the model collection bound to the application.
	 *
	 * @param Core\BootEvent $event
	 * @param Core|CoreBindings $app
	 */
	static public function on_core_boot(Core\BootEvent $event, Core $app)
	{
		ActiveRecord\Helpers::patch('get_model', function($id) use ($app) {

			return $app->models[$id];

		});
	}

	/*
	 * Prototypes
	 */

	/**
	 * Returns a @{link ConnectionCollection} instance configured with
	 * the `activerecord_connections` config.
	 *
	 * @param Core $app
	 *
	 * @return ConnectionCollection
	 */
	static public function core_lazy_get_connections(Core $app)
	{
		static $connections;

		if (!$connections)
		{
			$connections = new ConnectionCollection($app->configs['activerecord_connections'] ?: []);
		}

		return $connections;
	}

	/**
	 * Returns a @{link ModelCollection} instance configured with
	 * the `activerecord_models` config.
	 *
	 * @param Core|CoreBindings $app
	 *
	 * @return ModelCollection
	 */
	static public function core_lazy_get_models(Core $app)
	{
		static $models;

		if (!$models)
		{
			$models = new ModelCollection($app->connections, $app->configs['activerecord_models'] ?: []);
		}

		return $models;
	}

	/**
	 * Getter for the "primary" database connection.
	 *
	 * @param Core|CoreBindings $app
	 *
	 * @return Connection
	 */
	static public function core_lazy_get_db(Core $app)
	{
		return $app->connections['primary'];
	}

	/**
	 * @param ActiveRecord $record
	 *
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
	 *
	 * @param Model $model
	 *
	 * @return RuntimeActiveRecordCache
	 */
	static public function model_lazy_get_activerecord_cache(Model $model)
	{
		return new RuntimeActiveRecordCache($model);
	}
}
