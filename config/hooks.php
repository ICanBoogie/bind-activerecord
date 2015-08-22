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

$hooks = Hooks::class . '::';

return [

	'events' => [

		'ICanBoogie\Core::boot' => $hooks . 'on_core_boot'

	]

];
