<?php

namespace DbdbPhp\Composer\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbdbList extends MysqlBase
{
    const SCRIPT_PATH = __DIR__ . '/../../dbdb/dbdb.sh';

    protected function configure(): void
    {
        $this->setName('dbdb:list');
        $this->setDescription('description.........');
        $this->setHelp('help..........');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = self::SCRIPT_PATH;
        $command = "$file -f json";
        $scriptResponse = $this->exec($command);

        if ($scriptResponse['code'] === 0) {
            $output->writeln($scriptResponse['response']);
            return 0;
        }

        $output->writeln($scriptResponse['response']);
        return 1;
    }
}
