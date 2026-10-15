<?php

namespace ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\ModelProvider;
use ICanBoogie\ActiveRecord\StaticModelProvider;
use ICanBoogie\Application;

/**
 * Registered with `autoboot` in `composer.json`.
 */
final class Boot
{
    /**
     * Sets the factory for the {@see StaticModelProvider}.
     */
    public static function boot(Application $app): void
    {
        StaticModelProvider::set(
            static fn() => $app->service_for_class(ModelProvider::class)
        );
    }
}
