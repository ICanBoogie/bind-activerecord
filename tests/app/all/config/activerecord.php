<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\ConfigBuilder;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Node;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\NodeModel;

return fn(ConfigBuilder $config) => $config
    ->add_connection(Config::DEFAULT_CONNECTION_ID, 'sqlite::memory:')
    ->add_record(
        record_class: Node::class,
        model_class: NodeModel::class,
    );
