<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Schema;
use ICanBoogie\ActiveRecord\SchemaColumn;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Node;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\NodeModel;

return fn(ConfigBuilder $config) => $config
    ->add_connection(Config::DEFAULT_CONNECTION_ID, 'sqlite::memory:')
    ->add_model(
        id: 'nodes',
        schema: new Schema([
            'id' => SchemaColumn::serial(primary: true),
            'title' => SchemaColumn::varchar(),
        ]),
        activerecord_class: Node::class,
        model_class: NodeModel::class,
    );
