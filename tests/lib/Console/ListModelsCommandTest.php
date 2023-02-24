<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\Binding\ActiveRecord\Console\ListModelsCommand;
use ICanBoogie\Console\Test\CommandTestCase;

final class ListModelsCommandTest extends CommandTestCase
{
    public static function provideExecute(): array
    {
        return [

            [
                'activerecord:models',
                ListModelsCommand::class,
                [],
                [
                    'nodes',
                    'primary'
                ]
            ],

        ];
    }

    public function testAlias(): void
    {
        $loader = $this->getCommandLoader();
        $command1 = $loader->get('activerecord:models');
        $command2 = $loader->get('activerecord:models:list');

        $this->assertSame($command1, $command2);
    }
}
