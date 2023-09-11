<?php

namespace ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\ActiveRecord\Config;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('activerecord:connections', "List active record connections", [ 'activerecord:connections:list' ])]
final class ListConnectionsCommand extends Command
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

        foreach ($this->config->connections as $id => $attributes) {
            $rows[] = [
                $id,
                $attributes->dsn,
                $attributes->table_name_prefix ?? "",
            ];
        }

        $table = new Table($output);
        $table->setHeaders([ 'Id', 'DSN', 'Tables Prefix' ]);
        $table->setRows($rows);
        $table->setStyle($this->style);
        $table->render();

        return Command::SUCCESS;
    }
}
