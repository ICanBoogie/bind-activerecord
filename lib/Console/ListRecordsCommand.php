<?php

namespace ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\ActiveRecord\Config;
use ICanBoogie\ActiveRecord\Model;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('activerecord:records', "List ActiveRecords", [ 'activerecords' ])]
final class ListRecordsCommand extends Command
{
    public function __construct(
        private readonly Config $config,
        private readonly string $style,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = [];

        foreach ($this->config->models as $attributes) {
            $rows[] = [
                $attributes->activerecord_class,
                $attributes->model_class === Model::class ? "(default)" : $attributes->model_class,
                $attributes->connection,
            ];
        }

        $table = new Table($output);
        $table->setHeaders([ 'ActiveRecord', 'Model', 'Connection' ]);
        $table->setRows($rows);
        $table->setStyle($this->style);
        $table->render();

        return Command::SUCCESS;
    }
}
