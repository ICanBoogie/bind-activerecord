<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Schema;
use ICanBoogie\ActiveRecord\SchemaColumn;

return fn(ConfigBuilder $config) => $config
    ->add_connection('cache', 'sqlite::memory:')
    ->add_model(
        id: 'articles',
        schema: new Schema([
            'body' => SchemaColumn::text(),
            'date' => SchemaColumn::datetime(),
        ]),
        extends: 'nodes'
    );
