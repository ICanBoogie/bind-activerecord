<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\Binding\ActiveRecord\Console\ListConnectionsCommand;
use ICanBoogie\Console\Test\CommandTestCase;

final class ListConnectionsCommandTest extends CommandTestCase
{
    public static function provideExecute(): array
    {
        return [

            [
                'activerecord:connections',
                ListConnectionsCommand::class,
                [],
                [
                    'primary',
                    ''
                ]
            ],

        ];
    }

    public function testAlias(): void
    {
        $loader = $this->getCommandLoader();
        $command1 = $loader->get('activerecord:connections');
        $command2 = $loader->get('activerecord:connections:list');

        $this->assertSame($command1, $command2);
    }
}
