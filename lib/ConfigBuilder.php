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
use ICanBoogie\ActiveRecord\ConnectionOptions;
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\Schema;
use ICanBoogie\ActiveRecord\Table;
use ICanBoogie\Config\Builder;
use InvalidArgumentException;
use LogicException;

use function array_filter;
use function preg_match;

/**
 * @implements Builder<Config>
 */
final class ConfigBuilder implements Builder
{
    private const REGEXP_TIMEZONE = '/^[-+]\d{2}:\d{2}$/';

    public static function get_fragment_filename(): string
    {
        return 'activerecord';
    }

    /**
     * @param array<int|string, mixed> $array
     *
     * @return array<int|string, mixed>
     */
    private static function filter_non_null(array $array): array
    {
        return array_filter($array, fn(mixed $v): bool => $v !== null);
    }

    /**
     * @var array<string, array<ConnectionOptions::*, mixed>>
     */
    private array $connections = [];

    /**
     * @var array<string, array<Model::*, mixed>>
     */
    private array $models = [];

    public function build(): Config
    {
        return new Config($this->connections, $this->models);
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
        string $charset_and_collate = ConnectionOptions::DEFAULT_CHARSET_AND_COLLATE,
        string $time_zone = ConnectionOptions::DEFAULT_TIMEZONE,
    ): self {
        $this->assert_time_zone($time_zone);

        $this->connections[$id] = self::filter_non_null([ // @phpstan-ignore-line
            'dsn' => $dsn,
            'username' => $username,
            'password' => $password,
            'options' => self::filter_non_null([
                ConnectionOptions::ID => $id,
                ConnectionOptions::TABLE_NAME_PREFIX => $table_name_prefix,
                ConnectionOptions::CHARSET_AND_COLLATE => $charset_and_collate,
                ConnectionOptions::TIMEZONE => $time_zone,
            ])
        ]);

        return $this;
    }

    private function assert_time_zone(string $time_zone): void
    {
        $pattern = self::REGEXP_TIMEZONE;

        if (!preg_match($pattern, $time_zone)) {
            throw new InvalidArgumentException("Time zone doesn't match pattern '$pattern': $time_zone");
        }
    }

    public function add_model(
        string $id,
        Schema $schema,
        string $activerecord_class,
        string $connection = 'primary',
        string|null $name = null,
        string|null $alias = null,
        string|null $extends = null,
        string|null $implements = null,
        string|null $model_class = null,
        string|null $query_class = null,
        mixed $belongs_to = null,
        mixed $has_many = null,
    ): self {
        if ($activerecord_class === ActiveRecord::class) {
            throw new LogicException("\$activerecord_class must be an extension of ICanBoogie\ActiveRecord");
        }

        $this->models[$id] = self::filter_non_null([ // @phpstan-ignore-line
            Table::SCHEMA => $schema,
            Table::CONNECTION => $connection,
            Table::NAME => $name,
            Table::ALIAS => $alias,
            Table::EXTENDING => $extends,
            Table::IMPLEMENTING => $implements,
            Model::ID => $id,
            Model::ACTIVERECORD_CLASS => $activerecord_class,
            Model::CLASSNAME => $model_class,
            Model::QUERY_CLASS => $query_class,
            Model::BELONGS_TO => $belongs_to,
            Model::HAS_MANY => $has_many,
        ]);

        return $this;
    }
}
