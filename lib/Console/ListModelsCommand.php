<?php

namespace ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\Binding\ActiveRecord\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ListModelsCommand extends Command
{
    protected static $defaultDescription = "List active record models";

    public function __construct(
        private readonly Config $config,
        private readonly string $style,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = [];

        foreach ($this->config->models as $model_id => $attributes) {
            $rows[] = [
                $model_id,
                $attributes[Model::CONNECTION],
            ];
        }

        $table = new Table($output);
        $table->setHeaders([ 'Id', 'Connection' ]);
        $table->setRows($rows);
        $table->setStyle($this->style);
        $table->render();

        return Command::SUCCESS;
    }
}
