<?php

namespace ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\ActiveRecord;
use ICanBoogie\ActiveRecord\ModelIterator;
use ICanBoogie\ActiveRecord\ModelProvider;
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
        private readonly ModelProvider $models,
        private readonly ModelIterator $iterator,
        private readonly string $style,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var array<class-string<ActiveRecord>, bool> $tried */
        $tried = [];
        /** @var array<class-string<ActiveRecord>, true> $installed */
        $installed = [];
        /** @var array<class-string<ActiveRecord>, true> $already_installed */
        $already_installed = [];
        /** @var array<class-string<ActiveRecord>, string> $errors */
        $errors = [];

        $recursive_install = function (string $activerecord_class) use (
            &$recursive_install,
            &$tried,
            &$installed,
            &$already_installed,
            &$errors,
        ): bool {
            /** @var class-string<ActiveRecord> $activerecord_class */

            if (isset($tried[$activerecord_class])) {
                return $tried[$activerecord_class];
            }

            $model = $this->models->model_for_record($activerecord_class);

            if ($model->is_installed()) {
                $already_installed[$activerecord_class] = true;

                return $tried[$activerecord_class] = true;
            }

            $parent_activerecord_class = $model->parent?->activerecord_class;

            if ($parent_activerecord_class) {
                $rc = $recursive_install($parent_activerecord_class);

                if (!$rc) {
                    $errors[$activerecord_class] = "Parent install failed: '$parent_activerecord_class'";

                    return $tried[$activerecord_class] = false;
                }
            }

            try {
                $model->install();
                $installed[$activerecord_class] = true;

                return $tried[$activerecord_class] = true;
            } catch (Throwable $e) {
                $errors[$activerecord_class] = $e->getMessage();
            }

            return $tried[$activerecord_class] = false;
        };

        $rows = [];

        foreach ($this->iterator->model_iterator() as $activerecord_class => $_) {
            $recursive_install($activerecord_class);

            $rows[] = [
                $activerecord_class,
                isset($already_installed[$activerecord_class]) ? "Already" : (isset($installed[$activerecord_class]) ? "Yes" : "No"),
                $errors[$activerecord_class] ?? "",
            ];
        }

        $table = new Table($output);
        $table->setHeaders([ 'Record', 'Installed', 'Error' ]);
        $table->setRows($rows);
        $table->setStyle($this->style);
        $table->render();

        return count($errors)
            ? Command::FAILURE
            : Command::SUCCESS;
    }
}
