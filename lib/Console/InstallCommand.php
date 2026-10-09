<?php

namespace ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\ActiveRecord\InstallProgress;
use ICanBoogie\ActiveRecord\ModelInstaller;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand('activerecord:install', "Install models")]
final class InstallCommand extends Command
{
    public function __construct(
        private readonly ModelInstaller $installer,
        private readonly string $style,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $progress = new class () implements InstallProgress {
            /**
             * @var list<array{ string, string, string }>
             *     Rows of record class, state, and error.
             */
            public array $rows = [];
            public bool $failed = false;

            public function already_installed(string $activerecord_class): void
            {
                $this->rows[] = [ $activerecord_class, "Already", "" ];
            }

            public function installing(string $activerecord_class): void
            {
            }

            public function installed(string $activerecord_class): void
            {
                $this->rows[] = [ $activerecord_class, "Yes", "" ];
            }

            public function failed(string $activerecord_class, Throwable $error): void
            {
                $this->rows[] = [ $activerecord_class, "No", $error->getMessage() ];
                $this->failed = true;
            }

            public function skipped(string $activerecord_class, string $dependency): void
            {
                $this->rows[] = [ $activerecord_class, "Skipped", "Depends on $dependency" ];
                $this->failed = true;
            }
        };

        $this->installer->install($progress);

        $table = new Table($output);
        $table->setHeaders([ 'Record', 'Installed', 'Error' ]);
        $table->setRows($progress->rows);
        $table->setStyle($this->style);
        $table->render();

        return $progress->failed
            ? Command::FAILURE
            : Command::SUCCESS;
    }
}
