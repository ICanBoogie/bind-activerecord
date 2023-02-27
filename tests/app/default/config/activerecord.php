<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Schema;
use ICanBoogie\ActiveRecord\SchemaColumn;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Article;

return fn(ConfigBuilder $config) => $config
    ->add_connection('cache', 'sqlite::memory:')
    ->add_model(
        id: 'articles',
        schema: new Schema([
            'body' => SchemaColumn::text(),
            'date' => SchemaColumn::datetime(),
        ]),
        activerecord_class: Article::class,
        extends: 'nodes'
    );
