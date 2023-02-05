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

use ICanBoogie\ActiveRecord;
use ICanBoogie\ActiveRecord\ActiveRecordCache\RuntimeActiveRecordCache;
use ICanBoogie\ActiveRecord\Connection;
use ICanBoogie\ActiveRecord\ConnectionCollection;
use ICanBoogie\ActiveRecord\ConnectionProvider;
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\ModelCollection;
use ICanBoogie\ActiveRecord\ModelProvider;
use ICanBoogie\Application;
use ICanBoogie\Validate\ValidationErrors;

final class Hooks
{
    /*
     * Events
     */

    /**
     * Define model provider.
     *
     * Models are provided using the model collection bound to the application.
     */
    public static function on_app_boot(Application\BootEvent $event): void
    {
        ActiveRecord\StaticModelProvider::define(fn($id) => $event->app->models->model_for_id($id));
    }

    /*
     * Prototypes
     */

    private static function get_config(Application $app): Config
    {
        static $config;

        return $config ??= $app->configs->config_for_class(Config::class);
    }

    /**
     * Returns a {@link ConnectionProvider} instance configured with the `activerecord_connections` config.
     */
    public static function app_get_connections(Application $app): ConnectionProvider
    {
        static $connections;

        return $connections ??= new ConnectionCollection(self::get_config($app)->connections);
    }

    /**
     * Returns a {@link ModelProvider} instance configured with the `activerecord_models` config.
     */
    public static function app_get_models(Application $app): ModelProvider
    {
        static $models;

        return $models ??= new ModelCollection($app->connections, self::get_config($app)->models);
    }

    /**
     * Getter for the "primary" database connection.
     */
    public static function app_get_db(Application $app): Connection
    {
        static $db;

        return $db ??= $app->connections->connection_for_id(Config::DEFAULT_CONNECTION_ID);
    }

    /**
     * @return array<string, mixed>|ValidationErrors
     */
    public static function active_record_validate(ActiveRecord $record): array|ValidationErrors
    {
        static $validate;

        $validate ??= new ActiveRecord\Validate\ValidateActiveRecord();

        return $validate($record);
    }

    /**
     * Returns the records cache associated with the model.
     */
    public static function model_lazy_get_activerecord_cache(Model $model): RuntimeActiveRecordCache
    {
        return new RuntimeActiveRecordCache($model);
    }
}
