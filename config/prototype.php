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

$hooks = Hooks::class . '::';

return [

	ICanBoogie\Application::class . '::lazy_get_connections' => $hooks . 'app_lazy_get_connections',
	ICanBoogie\Application::class . '::lazy_get_models' => $hooks . 'app_lazy_get_models',
	ICanBoogie\Application::class . '::lazy_get_db' => $hooks . 'app_lazy_get_db',
	ICanBoogie\ActiveRecord::class . '::validate' => $hooks . 'active_record_validate',
	ICanBoogie\ActiveRecord\Model::class . '::lazy_get_activerecord_cache' => $hooks . 'model_lazy_get_activerecord_cache'

];
