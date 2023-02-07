<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\ConnectionCollection;
use ICanBoogie\ActiveRecord\ConnectionProvider;
use ICanBoogie\ActiveRecord\ModelCollection;
use ICanBoogie\ActiveRecord\ModelProvider;
use ICanBoogie\Application;

/**
 * Builds container services.
 */
final class Factory
{
    public static function build_config(Application $app): Config
    {
        return $app->configs->config_for_class(Config::class);
    }

    public static function build_connections(Config $config): ConnectionProvider
    {
        return new ConnectionCollection($config->connections);
    }

    public static function build_models(ConnectionProvider $connections, Config $config): ModelProvider
    {
        return new ModelCollection($connections, $config->models);
    }
}
