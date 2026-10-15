<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord;
use ICanBoogie\Prototype\ConfigBuilder;

return fn(ConfigBuilder $config) => $config
    ->bind(ActiveRecord::class, 'validate', [ Hooks::class, 'active_record_validate' ]);
