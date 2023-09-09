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
     * @param class-string<Model> $model_class
     * @param (Closure(SchemaBuilder $schema): SchemaBuilder)|null $schema_builder
     */
    public function add_model(
        string $model_class,
        string|null $table_name = null,
        string|null $alias = null,
        Closure $schema_builder = null,
        Closure $association_builder = null,
        string $connection = Config::DEFAULT_CONNECTION_ID,
    ): self {
        $this->inner->add_model(
            model_class: $model_class,
            table_name: $table_name,
            alias: $alias,
            schema_builder: $schema_builder,
            association_builder: $association_builder,
            connection: $connection,
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function use_attributes(): self
    {
        $this->inner->use_attributes();

        return $this;
    }
}
