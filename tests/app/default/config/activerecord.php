<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\SchemaBuilder;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Article;

return fn(ConfigBuilder $config) => $config
    ->add_connection('cache', 'sqlite::memory:')
    ->add_model(
        id: 'articles',
        schema_builder: fn(SchemaBuilder $schema) => $schema
            ->add_text('body')
            ->add_datetime('date'),
        activerecord_class: Article::class,
        extends: 'nodes'
    );
