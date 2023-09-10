<?php

namespace ICanBoogie\Binding\ActiveRecord;

use Attribute;
use ICanBoogie\ActiveRecord;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Record extends Autowire
{
    public const SERVICE_PREFIX = 'active_record.model.';

    public static function format_service_id(string $activerecord_class): string
    {
        return self::SERVICE_PREFIX . $activerecord_class;
    }

    /**
     * @param class-string<ActiveRecord> $activerecord_class
     */
    public function __construct( // @phpstan-ignore-line
        public readonly string $activerecord_class,
    ) {
        parent::__construct(
            service: self::format_service_id($activerecord_class)
        );
    }
}
