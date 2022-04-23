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

use ICanBoogie;
use ICanBoogie\ActiveRecord;
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\Application;
use ICanBoogie\Binding\Prototype\ConfigBuilder;

return fn(ConfigBuilder $config) => $config
	->bind(Application::class, 'lazy_get_connections', [ Hooks::class, 'app_lazy_get_connections' ])
	->bind(Application::class, 'lazy_get_models', [ Hooks::class, 'app_lazy_get_models' ])
	->bind(Application::class, 'lazy_get_db', [ Hooks::class, 'app_lazy_get_db' ])
	->bind(ActiveRecord::class, 'validate', [ Hooks::class, 'active_record_validate' ])
	->bind(Model::class, 'lazy_get_activerecord_cache', [ Hooks::class, 'model_lazy_get_activerecord_cache' ]);
