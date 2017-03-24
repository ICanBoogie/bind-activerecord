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

class SampleRecord extends ActiveRecord
{
	const MODEL_ID = 'dummy';

	/**
	 * @var string
	 */
	public $email;

	/**
	 * @inheritdoc
	 */
	public function create_validation_rules()
	{
		return [

			'email' => 'required|email'

		];
	}
}
