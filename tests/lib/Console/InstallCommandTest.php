<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\Binding\ActiveRecord\Console\InstallCommand;
use ICanBoogie\Console\Test\CommandTestCase;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Node;

final class InstallCommandTest extends CommandTestCase
{
    public static function provideExecute(): array
    {
        return [

            [
                'activerecord:install',
                InstallCommand::class,
                [],
                [
                    Node::class,
                    "Yes",
                    ""
                ]
            ],

        ];
    }
}
