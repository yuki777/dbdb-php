<?php

namespace DbdbPhp\Composer\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MysqlPort extends MysqlBase
{
    const SERVICE = 'mysql';

    const COMMAND = 'port';

    const SCRIPT_PATH = __DIR__ . '/../../dbdb/' . self::SERVICE . '/' . self::COMMAND . '.sh';

    protected function configure(): void
    {
        $this->setName('dbdb:' . self::SERVICE . '-' . self::COMMAND);
        $this->setDescription('Display ' . self::SERVICE . " database's port");

        $this->addArgument('name', InputArgument::REQUIRED, 'name, The required parameter');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $file = self::SCRIPT_PATH;
        $command = "$file -f json $name";
        $scriptResponse = $this->exec($command);

        if ($scriptResponse['code'] === 0) {
            $output->writeln(json_encode($scriptResponse['response'], JSON_PRETTY_PRINT));

            return 0;
        }

        $output->writeln($scriptResponse['response']);

        return 1;
    }
}
