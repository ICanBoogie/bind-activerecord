<?php

namespace Test\ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\ConfigBuilder;
use ICanBoogie\ActiveRecord\ConnectionRegistry;
use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\ActiveRecord\ModelInstaller;
use ICanBoogie\ActiveRecord\ModelRegistry;
use ICanBoogie\Binding\ActiveRecord\Console\InstallCommand;
use ICanBoogie\Binding\ActiveRecord\Console\ResetCommand;
use ICanBoogie\Console\Test\CommandTestCase;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Test\ICanBoogie\Binding\ActiveRecord\Acme\Node;

final class ResetCommandTest extends TestCase
{
    /**
     * @var Model<Node>
     */
    private Model $model;
    private ModelInstaller $installer;
    private ResetCommand $command;

    protected function setUp(): void
    {
        $config = new ConfigBuilder()
            ->add_connection(Config::DEFAULT_CONNECTION_ID, 'sqlite::memory:')
            ->add_record(Node::class)
            ->build();

        $models = new ModelRegistry(new ConnectionRegistry($config->connections), $config->models);
        $this->installer = new ModelInstaller($models);
        $this->command = new ResetCommand($this->installer, new InstallCommand($this->installer, 'default'));
        $this->model = $models->model_for_record(Node::class);

        $this->installer->install();
        $this->model->save([ 'title' => 'Some node' ]);

        parent::setUp();
    }

    /**
     * The command is registered, and the container provides its dependencies.
     */
    public function test_the_container_provides_the_command(): void
    {
        $tester = CommandTestCase::getTester('activerecord:reset', ResetCommand::class);

        $status = $tester->execute([ '--force' => true ]);

        $this->assertSame(Command::SUCCESS, $status);
        $this->assertStringContainsString(Node::class, $tester->getDisplay());
    }

    public function test_force_deletes_the_data_and_installs_the_models_again(): void
    {
        $tester = new CommandTester($this->command);

        $status = $tester->execute([ '--force' => true ]);

        $this->assertSame(Command::SUCCESS, $status);
        $this->assertTrue($this->model->is_installed());
        $this->assertSame(0, $this->model->query()->count);
        $this->assertStringContainsString(Node::class, $tester->getDisplay());
    }

    public function test_installs_the_models_that_were_not_installed(): void
    {
        $this->installer->uninstall();
        $tester = new CommandTester($this->command);

        $status = $tester->execute([ '--force' => true ]);

        $this->assertSame(Command::SUCCESS, $status);
        $this->assertTrue($this->model->is_installed());
    }

    public function test_confirmation_deletes_the_data(): void
    {
        $tester = new CommandTester($this->command);
        $tester->setInputs([ 'yes' ]);

        $status = $tester->execute([]);

        $this->assertSame(Command::SUCCESS, $status);
        $this->assertSame(0, $this->model->query()->count);
    }

    public function test_declining_keeps_the_data(): void
    {
        $tester = new CommandTester($this->command);
        $tester->setInputs([ 'no' ]);

        $status = $tester->execute([]);

        $this->assertSame(Command::FAILURE, $status);
        $this->assertSame(1, $this->model->query()->count);
    }

    public function test_refuses_without_force_when_not_interactive(): void
    {
        $tester = new CommandTester($this->command);

        $status = $tester->execute([], [ 'interactive' => false ]);

        $this->assertSame(Command::FAILURE, $status);
        $this->assertSame(1, $this->model->query()->count);
        $this->assertStringContainsString('--force', $tester->getDisplay());
    }
}
