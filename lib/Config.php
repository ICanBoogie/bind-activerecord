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

final class Config
{
    public const KEY = 'activerecord';
    public const DEFAULT_CONNECTION_ID = 'primary';

    /**
     * @param array{ 'connections': array<string, array>, 'models': array<string, array> } $an_array
     */
    public static function __set_state(array $an_array): self // @phpstan-ignore-line
    {
        return new self(
            $an_array['connections'],
            $an_array['models'],
        );
    }

    /**
     * @param array<string, array> $connections
     * @param array<string, array> $models
     */
    public function __construct(            // @phpstan-ignore-line
        public readonly array $connections, // @phpstan-ignore-line
        public readonly array $models,      // @phpstan-ignore-line
    ) {
    }
}