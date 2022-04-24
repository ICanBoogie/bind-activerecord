<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\ConnectionOptions;
use ICanBoogie\Binding\ActiveRecord\Config;
use PHPUnit\Framework\TestCase;

final class ConfigTest extends TestCase
{
	public function test_export(): void
	{
		$config = new Config(
			[
				'primary' => [
					'dsn' => 'mysql:dbname=myblog;host=mysql5-20',
					'username' => "olvlvl",
					'password' => "p455w0rd",
					'options' => [
						ConnectionOptions::ID => 'primary',
						ConnectionOptions::TABLE_NAME_PREFIX => 'myblog_',
						ConnectionOptions::CHARSET_AND_COLLATE => 'bin/general_ci',
						ConnectionOptions::TIMEZONE => '+02:00',
					]
				]
			],
			[
				// @TOOD: Models
			]
		);

		$actual = SetStateHelper::export_import($config);

		$this->assertEquals($config, $actual);
	}
}
