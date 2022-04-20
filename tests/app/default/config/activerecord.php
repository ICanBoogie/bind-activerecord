<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\Schema;
use ICanBoogie\ActiveRecord\SchemaColumn;

return [

	'connections' => [

		'cache' =>'sqlite::memory:'

	],

	'models' => [
		'articles' => [
			Model::SCHEMA => new Schema([
				'body' => SchemaColumn::text(),
				'date' => SchemaColumn::datetime(),
			])
		]
	]
];
