<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\SchemaBuilder;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\NodeModel;

return fn(ConfigBuilder $config) => $config
    ->add_connection(Config::DEFAULT_CONNECTION_ID, 'sqlite::memory:')
    ->add_model(
        id: 'nodes',
        model_class: NodeModel::class,
        schema_builder: fn(SchemaBuilder $schema) => $schema
            ->add_serial('id', primary: true)
            ->add_character('title'),
    );
