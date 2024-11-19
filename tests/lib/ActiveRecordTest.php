<?php

namespace Test\ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\Validate\ValidationErrors;
use PHPUnit\Framework\TestCase;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Article;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\SampleRecord;

final class ActiveRecordTest extends TestCase
{
    public function test_validate(): void
    {
        $record = new SampleRecord();

        $this->assertInstanceOf(ValidationErrors::class, $record->validate());
    }

    public function test_model(): void
    {
        $record = Article::from();

        $this->assertEquals(Article::class, $record->model->activerecord_class);
    }
}
