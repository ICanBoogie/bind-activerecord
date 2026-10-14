<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\ConfigBuilder;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Article;

return fn(ConfigBuilder $config) => $config
    ->add_connection('cache', 'sqlite::memory:')
    ->add_record(Article::class);
