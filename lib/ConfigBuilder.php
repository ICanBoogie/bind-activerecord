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

use Closure;
use ICanBoogie\ActiveRecord;
use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\Config\ConnectionDefinition;
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\Query;
use ICanBoogie\ActiveRecord\SchemaBuilder;
use ICanBoogie\Config\Builder;

/**
 * @implements Builder<Config>
 */
final class ConfigBuilder implements Builder
{
    public static function get_fragment_filename(): string
    {
        return 'activerecord';
    }

    private readonly ActiveRecord\ConfigBuilder $inner;

    public function __construct()
    {
        $this->inner = new ActiveRecord\ConfigBuilder();
    }

    public function build(): Config
    {
        return $this->inner->build();
    }

    /**
     * @return $this
     */
    public function add_connection(
        string $id,
        string $dsn,
        string|null $username = null,
        string|null $password = null,
        string|null $table_name_prefix = null,
        string $charset_and_collate = ConnectionDefinition::DEFAULT_CHARSET_AND_COLLATE,
        string $time_zone = ConnectionDefinition::DEFAULT_TIMEZONE,
    ): self {
        $this->inner->add_connection(
            id: $id,
            dsn: $dsn,
            username: $username,
            password: $password,
            table_name_prefix: $table_name_prefix,
            charset_and_collate: $charset_and_collate,
            time_zone: $time_zone
        );

        return $this;
    }

    /**
     * @param (Closure(SchemaBuilder $schema): SchemaBuilder) $schema_builder
     * @param class-string<ActiveRecord> $activerecord_class
     * @param class-string<Model<int|string, ActiveRecord>>|null $model_class
     * @param class-string<Query<ActiveRecord>>|null $query_class
     */
    public function add_model(
        string $id,
        Closure $schema_builder,
        string $activerecord_class,
        string $connection = Config::DEFAULT_CONNECTION_ID,
        string|null $name = null,
        string|null $alias = null,
        string|null $extends = null,
        string|null $implements = null,
        string|null $model_class = null,
        string|null $query_class = null,
        Closure $association_builder = null,
    ): self {
        $this->inner->add_model(
            id: $id,
            schema_builder: $schema_builder,
            activerecord_class: $activerecord_class,
            connection: $connection,
            name: $name,
            alias: $alias,
            extends: $extends,
            implements: $implements,
            model_class: $model_class,
            query_class: $query_class,
            association_builder: $association_builder,
        );

        return $this;
    }
}
