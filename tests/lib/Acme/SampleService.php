<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Acme;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\Binding\ActiveRecord\Record;

final class SampleService
{
    /**
     * @param Model<int, Article> $model
     */
    public function __construct(
        #[Record(Article::class)] public readonly Model $model,
    ) {
    }
}
