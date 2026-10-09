<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\ConfigBuilder;
use ICanBoogie\ActiveRecord\ConnectionRegistry;
use ICanBoogie\ActiveRecord\ModelInstaller;
use ICanBoogie\ActiveRecord\ModelRegistry;
use ICanBoogie\ActiveRecord\SchemaBuilder;
use ICanBoogie\Binding\ActiveRecord\Console\InstallCommand;
use ICanBoogie\Console\Test\CommandTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Article;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\FailingModel;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Node;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\SampleRecord;

use function preg_match;
use function preg_quote;

use const PREG_OFFSET_CAPTURE;

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

    public function test_reports_failed_and_skipped_models(): void
    {
        $config = new ConfigBuilder()
            ->use_attributes()
            ->add_connection(Config::DEFAULT_CONNECTION_ID, 'sqlite::memory:')
            ->add_record(Article::class)
            ->add_record(Node::class, model_class: FailingModel::class)
            ->add_record(
                record_class: SampleRecord::class,
                schema_builder: fn(SchemaBuilder $schema) => $schema
                    ->add_serial('id', primary: true)
                    ->add_character('email'),
            )
            ->build();

        $models = new ModelRegistry(new ConnectionRegistry($config->connections), $config->models);
        $tester = new CommandTester(new InstallCommand(new ModelInstaller($models), 'default'));

        $this->assertSame(Command::FAILURE, $tester->execute([]));

        $display = $tester->getDisplay();

        $this->assertDisplayContainsRow([ Node::class, "No", "Unable to install" ], $display);
        $this->assertDisplayContainsRow([ Article::class, "Skipped", "Depends on " . Node::class ], $display);
        $this->assertDisplayContainsRow([ SampleRecord::class, "Yes", "" ], $display);

        // Rows follow the install order, the parent comes before the model extending it.
        $this->assertLessThan(self::row_offset(Article::class, $display), self::row_offset(Node::class, $display));
    }

    /**
     * Returns the offset of the row starting with a record class.
     */
    private static function row_offset(string $activerecord_class, string $display): int
    {
        self::assertSame(1, preg_match(
            '/^\\|\\s+' . preg_quote($activerecord_class, '/') . '\\s/m',
            $display,
            $matches,
            PREG_OFFSET_CAPTURE
        ));

        return $matches[0][1];
    }
}
