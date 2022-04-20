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

return [

	Application::class . '::lazy_get_connections' => [ Hooks::class, 'app_lazy_get_connections' ],
	Application::class . '::lazy_get_models' => [ Hooks::class, 'app_lazy_get_models' ],
	Application::class . '::lazy_get_db' => [ Hooks::class, 'app_lazy_get_db' ],
	ActiveRecord::class . '::validate' => [ Hooks::class, 'active_record_validate' ],
	Model::class . '::lazy_get_activerecord_cache' => [ Hooks::class, 'model_lazy_get_activerecord_cache' ],

];
