<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\Schema;
use ICanBoogie\ActiveRecord\SchemaColumn;

return [

	'connections' => [

		'primary' => 'sqlite::memory:'

	],

	'models' => [

		'nodes' => [
			Model::SCHEMA => new Schema([
				'id' => SchemaColumn::serial(),
				'title' => SchemaColumn::varchar(),
			])
		]
	]
];
