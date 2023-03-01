<?php

namespace DbdbPhp\Composer\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\Command\BaseCommand;

class DbdbList extends BaseCommand
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
        $scriptResponse = $this->exec();

        if ($scriptResponse['code'] === 0) {
            $text = implode('', $scriptResponse['response']);
            $output->writeln($text);
            return 0;
        }

        return 1;
    }

    private function exec()
    {
        $file = self::SCRIPT_PATH;
        $command = "$file -f json";

        exec($command, $response, $code);

        return [
            'command' => $command,
            'response' => $response,
            'code' => $code,
        ];
    }
}
