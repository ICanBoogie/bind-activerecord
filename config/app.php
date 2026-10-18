<?php

namespace ICanBoogie;

use ICanBoogie\Binding\ActiveRecord\ActiveRecordServerTimingProvider;

return fn(AppConfigBuilder $config) => $config
    ->add_server_timing_provider(ActiveRecordServerTimingProvider::class);
