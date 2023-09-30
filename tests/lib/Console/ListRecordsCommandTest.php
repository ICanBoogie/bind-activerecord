<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\Binding\ActiveRecord\Console\ListRecordsCommand;
use ICanBoogie\Console\Test\CommandTestCase;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Node;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\NodeModel;

final class ListRecordsCommandTest extends CommandTestCase
{
    public static function provideExecute(): array
    {
        return [

            [
                'activerecord:records',
                ListRecordsCommand::class,
                [],
                [
                    Node::class,
                    NodeModel::class,
                    'primary'
                ]
            ],

        ];
    }

    public function testAlias(): void
    {
        $loader = $this->getCommandLoader();
        $command1 = $loader->get('activerecord:records');
        $command2 = $loader->get('activerecords');

        $this->assertSame($command1, $command2);
    }
}
