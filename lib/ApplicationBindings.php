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

use ICanBoogie\ActiveRecord\Connection;
use ICanBoogie\ActiveRecord\ConnectionProvider;
use ICanBoogie\ActiveRecord\ModelProvider;

/**
 * {@link \ICanBoogie\Application} prototype bindings.
 *
 * @property ConnectionProvider $connections
 * @property ModelProvider $models
 * @property Connection $db
 */
trait ApplicationBindings
{
}
