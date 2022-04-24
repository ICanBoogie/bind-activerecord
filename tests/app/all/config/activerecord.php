<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Schema;
use ICanBoogie\ActiveRecord\SchemaColumn;

return fn(ConfigBuilder $config) => $config
	->add_connection(Config::DEFAULT_CONNECTION_ID, 'sqlite::memory:')
	->add_model(
		'nodes',
		new Schema([
			'id' => SchemaColumn::serial(),
			'title' => SchemaColumn::varchar(),
		])
	);
