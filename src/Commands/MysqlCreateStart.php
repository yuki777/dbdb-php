<?php

namespace DbdbPhp\Composer\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MysqlCreateStart extends MysqlBase
{
    const SERVICE = 'mysql';

    const COMMAND = 'create-start';

    const SCRIPT_PATH = __DIR__ . '/../../dbdb/' . self::SERVICE . '/' . self::COMMAND . '.sh';

    protected function configure(): void
    {
        $this->setName('dbdb:' . self::SERVICE . '-' . self::COMMAND);
        $this->setDescription('Create database, then start database');

        $this->addUsage('dbdb:' . self::SERVICE . '-' . self::COMMAND . ' my-awesome-mysql5 5.7.31 3306');
        $this->addUsage('dbdb:' . self::SERVICE . '-' . self::COMMAND . ' my-awesome-mysql8 8.0.30 13306');
        $this->addUsage('dbdb:' . self::SERVICE . '-' . self::COMMAND . ' mysql-random-port 8.0.30 random');

        $this->addArgument('name', InputArgument::REQUIRED, 'name, The required parameter');
        $this->addArgument('version', InputArgument::REQUIRED, 'version, The required parameter');
        $this->addArgument('port', InputArgument::REQUIRED, 'port, The required parameter. If you want to use a random port, use "random"');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $version = $input->getArgument('version');
        $port = $input->getArgument('port');

        $file = self::SCRIPT_PATH;
        $command = "$file -f json $name $version $port";
        $scriptResponse = $this->exec($command);

        if ($scriptResponse['code'] === 0) {
            $output->writeln(json_encode($scriptResponse['response'], JSON_PRETTY_PRINT));

            return 0;
        }

        $output->writeln($scriptResponse['response']);

        return 1;
    }
}
