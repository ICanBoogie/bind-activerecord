<?php

namespace ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\ActiveRecord\ModelIterator;
use ICanBoogie\ActiveRecord\ModelProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

use function array_filter;

final class InstallCommand extends Command
{
    protected static $defaultDescription = "Install models";

    public function __construct(
        private readonly ModelProvider $models,
        private readonly ModelIterator $iterator,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tried = [];

        $recursive_install = function (string $id) use (&$recursive_install, &$tried, $output): bool {
            if (isset($tried[$id])) {
                return $tried[$id];
            }

            $model = $this->models->model_for_id($id);

            if ($model->is_installed()) {
                $output->writeln("<info>Model already installed: $id</info>");

                return $tried[$id] = true;
            }

            $parent_id = $model->parent?->id;

            if ($parent_id) {
                $rc = $recursive_install($parent_id);

                if (!$rc) {
                    $output->writeln("<error>Unable to install model '$id', parent install failed: '{$parent_id}'");

                    return $tried[$id] = false;
                }
            }

            try {
                $model->install();
                $output->writeln("<info>Model installed: $id</info>");

                return $tried[$id] = true;
            } catch (Throwable $e) {
                $output->writeln("<error>Unable to install model '$id': {$e->getMessage()}</error>");
            }

            return $tried[$id] = false;
        };

        foreach ($this->iterator->model_iterator() as $id => $_) {
            $recursive_install($id);
        }

        return count(array_filter($tried, fn ($v) => $v === false))
            ? Command::FAILURE
            : Command::SUCCESS;
    }
}
