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

use ICanBoogie\Validate\ValidationErrors;
use PHPUnit\Framework\TestCase;

/**
 * @small
 */
class ActiveRecordTest extends TestCase
{
	public function test_validate()
	{
		$record = new SampleRecord;

		$this->assertInstanceOf(ValidationErrors::class, $record->validate());
	}
}
