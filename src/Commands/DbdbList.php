<?php

namespace DbDbPhp\Composer\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbDbList extends DbDbBase
{
    const SCRIPT_PATH = __DIR__ . '/../../dbdb/dbdb.sh';

    protected function configure(): void
    {
        $this->setName('dbdb:list');
        $this->setDescription('Displays all databases managed by dbdb-php');

        $this->addUsage('dbdb:list | jq');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = self::SCRIPT_PATH;
        $command = "$file -f json";
        $scriptResponse = $this->exec($command);
        $scriptResponse['response'] = $this->convertResponse($scriptResponse['response']);

        if ($scriptResponse['code'] === 0) {
            $output->writeln(json_encode($scriptResponse['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            return 0;
        }

        $output->writeln($scriptResponse['response']);

        return 1;
    }

    // Return only name, type, version, port, status, dataDir, confPath
    private function convertResponse(array $response)
    {
        if (! $response) {
            return [];
        }

        $dbList = [];
        foreach ($response as $db) {
            $item = [];
            $item['name'] = $db['name'];
            $item['type'] = $db['type'];
            $item['version'] = $db['version'];
            $item['port'] = $db['port'];
            $item['status'] = $db['status'];
            $item['dataDir'] = $db['dataDir'];
            $item['confPath'] = $db['confPath'];
            $dbList[] = $item;
        }
        return $dbList;
    }
}
