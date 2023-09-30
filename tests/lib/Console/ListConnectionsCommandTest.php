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
}
