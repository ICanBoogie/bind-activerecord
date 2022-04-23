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

use ICanBoogie\Application;
use ICanBoogie\Binding\Event\ConfigBuilder;

return fn(ConfigBuilder $config) => $config
	->attach_to(Application::class, Application\BootEvent::class, [ Hooks::class, 'on_app_boot' ]);
