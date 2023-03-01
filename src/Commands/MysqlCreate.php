<?php

namespace DbdbPhp\Composer\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MysqlCreate extends MysqlBase
{
    const SERVICE = 'mysql';
    const COMMAND = 'create';
    const SCRIPT_PATH = __DIR__ . '/../../dbdb/' . self::SERVICE . '/' . self::COMMAND . '.sh';

    protected function configure(): void
    {
        $this->setName('dbdb:' . self::SERVICE . '-' . self::COMMAND);
        $this->setDescription('description.........');
        $this->setHelp('help..........');

        $this->addArgument('name', InputArgument::REQUIRED, 'name, The required parameter');
        $this->addArgument('version', InputArgument::REQUIRED, 'version, The required parameter');
        $this->addArgument('port', InputArgument::REQUIRED, 'port, The required parameter');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $version = $input->getArgument('version');
        $port = $input->getArgument('port');

        $file = self::SCRIPT_PATH;
        $command = "$file $name $version $port";
        $scriptResponse = $this->exec($command);

        if ($scriptResponse['code'] === 0) {
            $output->writeln(ucfirst(self::COMMAND) . ' ' . self::SERVICE . " command was successfully executed. $name $version $port");
            $output->writeln($scriptResponse['response']);
            return 0;
        }

        $output->writeln($scriptResponse['response']);
        return 1;
    }
}
