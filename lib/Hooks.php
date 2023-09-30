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
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\ModelProvider;
use ICanBoogie\ActiveRecord\StaticModelProvider;
use ICanBoogie\Application;
use ICanBoogie\Validate\ValidationErrors;

final class Hooks
{
    /*
     * Events
     */

    /**
     * Sets the factory for the {@link StaticModelProvider}.
     */
    public static function on_app_boot(Application\BootEvent $event): void
    {
        StaticModelProvider::define(
            static fn() => $event->app->service_for_class(ModelProvider::class)
        );
    }

    /*
     * Prototypes
     */

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
