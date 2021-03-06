<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Model;

return [

	'connections' => [

		'primary' => 'sqlite::memory:'

	],

	'models' => [

		'nodes' => [

			Model::SCHEMA => [

				'id' => 'serial',
				'title' => 'varchar'

			]
		]
	]
];
