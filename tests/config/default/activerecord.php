<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Model;

return [

	'connections' => [

		'cache' =>'sqlite::memory:'

	],

	'models' => [

		'articles' => [

			Model::SCHEMA => [

				'fields' => [

					'body' => 'text',
					'date' => 'datetime'

				]
			]
		]
	]
];
