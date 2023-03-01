<?php

namespace DbdbPhp\Composer\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\Command\BaseCommand;

class MysqlStart extends BaseCommand
{
    const SERVICE = 'mysql';
    const COMMAND = 'start';
    const SCRIPT_PATH = __DIR__ . '/../../dbdb/' . self::SERVICE . '/' . self::COMMAND . '.sh';

    protected function configure(): void
    {
        $this->setName('dbdb:' . self::SERVICE . '-' . self::COMMAND);
        $this->setDescription('description.........');
        $this->setHelp('help..........');

        $this->addArgument('name', InputArgument::REQUIRED, 'name, The required parameter');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $scriptResponse = $this->exec($name);

        if ($scriptResponse['code'] === 0) {
            $output->writeln(ucfirst(self::SERVICE) . ' ' . self::COMMAND . " command was successfully executed.");
            return 0;
        }

        return 1;
    }

    private function exec(string $name)
    {
        $file = self::SCRIPT_PATH;
        $command = "$file $name";

        return shell_exec($command);
    }
}
