<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\ConnectionProvider;
use ICanBoogie\ActiveRecord\ConnectionRegistry;
use ICanBoogie\ActiveRecord\ModelProvider;
use ICanBoogie\ActiveRecord\ModelRegistry;

/**
 * Builds container services.
 */
final class Factory
{
    public static function build_connections(Config $config): ConnectionProvider
    {
        return new ConnectionRegistry($config->connections);
    }

    public static function build_models(ConnectionProvider $connections, Config $config): ModelProvider
    {
        return new ModelRegistry($connections, $config->models);
    }
}
