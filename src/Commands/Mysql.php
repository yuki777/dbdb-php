<?php

namespace DbDbPhp\Composer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Mysql extends DbDbBase
{
    const SERVICE = 'mysql';
    const SCRIPT_DIR = __DIR__ . '/../../dbdb/' . self::SERVICE;
    const AVAILABLE_COMMANDS = ['create', 'create-start', 'delete', 'port', 'restart', 'start', 'stop'];

    protected function configure(): void
    {
        $this->setName('dbdb:' . self::SERVICE);
        $this->setDescription('Manage ' . self::SERVICE . ' databases.')
        ->addArgument('action', InputArgument::REQUIRED, 'The action to perform: ' . implode(', ', self::AVAILABLE_COMMANDS))
        ->addOption('db-name', null, InputOption::VALUE_REQUIRED, 'The name of the database.')
        ->addOption('db-version', null, InputOption::VALUE_REQUIRED, 'The version of the database.')
        ->addOption('db-port', null, InputOption::VALUE_REQUIRED, 'The port of the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $action = $input->getArgument('action');
        $name = $input->getOption('db-name');
        $version = $input->getOption('db-version');
        $port = $input->getOption('db-port');

        switch ($action) {
            case 'create':
            case 'create-start':
                if (empty($name) || empty($version) || empty($port)) {
                    $output->writeln("<error>For the $action action, you must provide the db-name, db-version, and db-port options.</error>");
                    $output->writeln('e.g.');
                    $output->writeln("composer dbdb:" . self::SERVICE . " $action --db-name=my-mysql-5 --db-version=5.7.31 --db-port=3306");
                    $output->writeln("composer dbdb:" . self::SERVICE . " $action --db-name=my-mysql-8-random --db-version=8.0.30 --db-port=random");
                    return Command::FAILURE;
                }
                return $this->action($action, $input, $output);
                break;
            case 'delete':
            case 'port':
            case 'restart':
            case 'start':
            case 'stop':
                if (empty($name)) {
                    $output->writeln("<error>For the $action action, you must provide the db-name option.</error>");
                    $output->writeln('e.g.');
                    $output->writeln("composer dbdb:" . self::SERVICE . " $action --db-name=my-redis-6");
                    return Command::FAILURE;
                }
                return $this->action($action, $input, $output);
                break;
            default:
                $output->writeln('<error>Invalid action. Please use ' . implode(', ', self::AVAILABLE_COMMANDS) . '.</error>');
                return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function action(string $action, InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getOption('db-name');
        $version = $input->getOption('db-version');
        $port = $input->getOption('db-port');

        $file = self::SCRIPT_DIR . "/$action.sh";
        $command = "$file -f json $name $version $port";
        $scriptResponse = $this->exec($command);

        if ($scriptResponse['code'] === 0) {
            $output->writeln(json_encode($scriptResponse['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            return Command::SUCCESS;
        }

        $output->writeln($scriptResponse['response']);

        return Command::FAILURE;
    }
}
