<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie;

require __DIR__ . '/../vendor/autoload.php';

(new Core(array_merge_recursive(get_autoconfig(), [

	'config-path' => [

		__DIR__ . '/config/all' => 10,
		__DIR__ . '/config/default' => 10,
		__DIR__ . '/config/localhost' => 10

	]

])))->boot();
