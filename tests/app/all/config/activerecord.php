<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Schema;
use ICanBoogie\ActiveRecord\SchemaColumn;

return fn(ConfigBuilder $config) => $config
	->add_connection('primary', 'sqlite::memory:')
	->add_model(
		'nodes',
		new Schema([
			'id' => SchemaColumn::serial(),
			'title' => SchemaColumn::varchar(),
		])
	);
