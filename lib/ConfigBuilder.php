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
use ICanBoogie\ActiveRecord\Config\AssociationBuilder;
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
     * Adds a connection definition.
     *
     * @param non-empty-string $id
     * @param non-empty-string $dsn
     * @param non-empty-string|null $username
     * @param non-empty-string|null $password
     * @param non-empty-string|null $table_name_prefix
     * @param non-empty-string $charset_and_collate
     * @param non-empty-string $time_zone
     *
     * @return $this
     *
     * @uses ActiveRecord\ConfigBuilder::add_connection()
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
     * Adds a record definition.
     *
     * @param class-string<ActiveRecord> $record_class
     * @param class-string<Model> $model_class
     * @param class-string<Query> $query_class
     * @param non-empty-string|null $table_name
     * @param non-empty-string|null $alias
     * @param (Closure(SchemaBuilder): SchemaBuilder)|null $schema_builder
     * @param (Closure(AssociationBuilder): AssociationBuilder)|null $association_builder
     * @param non-empty-string $connection
     *
     * @return $this
     *
     * @uses ActiveRecord\ConfigBuilder::add_record()
     */
    public function add_record( // @phpstan-ignore-line
        string $record_class,
        string $model_class = Model::class,
        string $query_class = Query::class,
        string|null $table_name = null,
        string|null $alias = null,
        Closure $schema_builder = null,
        Closure $association_builder = null,
        string $connection = Config::DEFAULT_CONNECTION_ID,
    ): self {
        $this->inner->add_record(
            record_class: $record_class,
            model_class: $model_class,
            query_class: $query_class,
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
     *
     * @uses ActiveRecord\ConfigBuilder::use_attributes()
     */
    public function use_attributes(): self
    {
        $this->inner->use_attributes();

        return $this;
    }
}
