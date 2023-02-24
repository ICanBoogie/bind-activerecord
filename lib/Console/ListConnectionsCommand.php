<?php

namespace ICanBoogie\Binding\ActiveRecord\Console;

use ICanBoogie\ActiveRecord\ConnectionOptions;
use ICanBoogie\Binding\ActiveRecord\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ListConnectionsCommand extends Command
{
    protected static $defaultDescription = "List active record connections";

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
                $attributes[ConnectionOptions::TABLE_NAME_PREFIX] ?? "",
            ];
        }

        $table = new Table($output);
        $table->setHeaders([ 'Id', 'Tables Prefix' ]);
        $table->setRows($rows);
        $table->setStyle($this->style);
        $table->render();

        return Command::SUCCESS;
    }
}
