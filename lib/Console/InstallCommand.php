<?php

namespace ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\ActiveRecord;
use ICanBoogie\ActiveRecord\ModelIterator;
use ICanBoogie\ActiveRecord\ModelProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

use function array_filter;
use function sprintf;

#[AsCommand('activerecord:install', "Install models")]
final class InstallCommand extends Command
{
    public function __construct(
        private readonly ModelProvider $models,
        private readonly ModelIterator $iterator,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /**
         * @var array<class-string<ActiveRecord>, true|null> $tried
         */
        $tried = [];

        $recursive_install = function (string $activerecord_class) use (&$recursive_install, &$tried, $output): bool {
            /** @var class-string<ActiveRecord> $activerecord_class */

            if (isset($tried[$activerecord_class])) {
                return $tried[$activerecord_class];
            }

            $model = $this->models->model_for_record($activerecord_class);

            if ($model->is_installed()) {
                $output->writeln("<info>Model already installed: $activerecord_class</info>");

                return $tried[$activerecord_class] = true;
            }

            $parent_activerecord_class = $model->parent?->activerecord_class;

            if ($parent_activerecord_class) {
                $rc = $recursive_install($parent_activerecord_class);

                if (!$rc) {
                    $output->writeln(
                        sprintf(
                            "<error>Unable to install model '%s', parent install failed: '%s'",
                            $activerecord_class,
                            $parent_activerecord_class
                        )
                    );

                    return $tried[$activerecord_class] = false;
                }
            }

            try {
                $model->install();
                $output->writeln("<info>Model installed: $activerecord_class</info>");

                return $tried[$activerecord_class] = true;
            } catch (Throwable $e) {
                $output->writeln("<error>Unable to install model '$activerecord_class': {$e->getMessage()}</error>");
            }

            return $tried[$activerecord_class] = false;
        };

        foreach ($this->iterator->model_iterator() as $activerecord_class => $_) {
            $recursive_install($activerecord_class);
        }

        return count(array_filter($tried, fn($v) => $v === false))
            ? Command::FAILURE
            : Command::SUCCESS;
    }
}
