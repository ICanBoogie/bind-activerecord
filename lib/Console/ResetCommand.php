<?php

namespace ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\ActiveRecord\ModelInstaller;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

/**
 * Uninstalls the models, which deletes their tables and their data, then installs them again.
 *
 * Only the tables of the models are dropped, tables unknown to ActiveRecord are left alone.
 */
#[AsCommand('activerecord:reset', "Uninstall then install the models, which deletes their data")]
final class ResetCommand extends Command
{
    public function __construct(
        private readonly ModelInstaller $installer,
        private readonly InstallCommand $install,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('force', 'f', InputOption::VALUE_NONE, "Do not ask for confirmation");
    }

    /**
     * @throws Throwable if a model fails to uninstall.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Not interactive, `confirm()` answers with its default: refusing, unless forced.
        $confirmed = $input->getOption('force')
            || $io->confirm("This deletes the data of all the models, continue?", false);

        if (!$confirmed) {
            $io->error("Aborted, use --force to reset without confirmation.");

            return Command::FAILURE;
        }

        $this->installer->uninstall();

        return $this->install->run(new ArrayInput([]), $output);
    }
}
