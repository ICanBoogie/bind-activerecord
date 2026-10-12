<?php

namespace Test\ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\ActiveRecordCache;
use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\Config\TableDefinition;
use ICanBoogie\ActiveRecord\ConnectionProvider;
use ICanBoogie\ActiveRecord\ModelProvider;
use ICanBoogie\ActiveRecord\Query;
use ICanBoogie\ActiveRecord\SchemaBuilder;
use ICanBoogie\Binding\ActiveRecord\Hooks;
use ICanBoogie\Validate\ValidationErrors;
use PHPUnit\Framework\TestCase;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Node;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\NodeModel;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\SampleRecord;

use function ICanBoogie\app;

final class HooksTest extends TestCase
{
    public function test_active_record_validate(): void
    {
        $record = new SampleRecord();

        $this->assertInstanceOf(ValidationErrors::class, Hooks::active_record_validate($record));
    }
}
