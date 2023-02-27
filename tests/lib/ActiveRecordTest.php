<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Binding\ActiveRecord;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\Validate\ValidationErrors;
use PHPUnit\Framework\TestCase;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Article;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\SampleRecord;

/**
 * @small
 */
final class ActiveRecordTest extends TestCase
{
    public function test_validate(): void
    {
        $record = new SampleRecord();

        $this->assertInstanceOf(ValidationErrors::class, $record->validate());
    }

    public function test_model_id(): void
    {
        $record = Article::from();

        $this->assertEquals('articles', $record->model_id);
    }

    public function test_model(): void
    {
        $record = Article::from();

        $this->assertInstanceOf(Model::class, $record->model);
        $this->assertEquals('articles', $record->model->id);
    }
}
