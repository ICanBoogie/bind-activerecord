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
use ICanBoogie\ActiveRecord\ConnectionCollection;
use ICanBoogie\ActiveRecord\ModelCollection;

/**
 * {@link \ICanBoogie\Core} prototype bindings.
 *
 * @property ConnectionCollection $connections
 * @property ModelCollection $models
 * @property Connection $db
 */
trait CoreBindings
{
	/**
	 * @return ConnectionCollection
	 */
	protected function lazy_get_connections()
	{
		return parent::lazy_get_connections();
	}

	/**
	 * @return ModelCollection
	 */
	protected function lazy_get_models()
	{
		return parent::lazy_get_models();
	}

	/**
	 * @return Connection
	 */
	protected function lazy_get_db()
	{
		return parent::lazy_get_db();
	}
}
