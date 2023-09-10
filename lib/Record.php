<?php

namespace ICanBoogie\Binding\ActiveRecord;

use Attribute;
use ICanBoogie\ActiveRecord;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

use function sprintf;
use function str_replace;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Record extends Autowire
{
    /**
     * @param class-string<ActiveRecord> $activerecord_class
     */
    public function __construct( // @phpstan-ignore-line
        public readonly string $activerecord_class,
    ) {
        parent::__construct(
            expression: sprintf(
                "service('%s').model_for_activerecord('%s')",
                self::escape(ActiveRecord\ModelProvider::class),
                self::escape($this->activerecord_class)
            )
        );
    }

    private static function escape(string $str): string {
        return str_replace('\\', '\\\\', $str);
    }
}
