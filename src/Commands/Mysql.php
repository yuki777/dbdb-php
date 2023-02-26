<?php

namespace DbdbPhp\Composer\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Composer\Command\BaseCommand;

class Mysql extends BaseCommand
{
    const SERVICE             = 'mysql';
    const SCRIPT_PATH         = __DIR__ . '/../../dbdb/' . self::SERVICE;
    const DBDB_SCRIPT         = self::SCRIPT_PATH . '/../dbdb.sh';
    const CREATE_SCRIPT       = self::SCRIPT_PATH . '/create.sh';
    const START_SCRIPT        = self::SCRIPT_PATH . '/start.sh';
    const STOP_SCRIPT         = self::SCRIPT_PATH . '/stop.sh';
    const RESTART_SCRIPT      = self::SCRIPT_PATH . '/restart.sh';
    const PORT_SCRIPT         = self::SCRIPT_PATH . '/port.sh';
    const DELETE_SCRIPT       = self::SCRIPT_PATH . '/delete.sh';
    const CREATE_START_SCRIPT = self::SCRIPT_PATH . '/create-start.sh';

    protected function configure(): void
    {
        $this->setName('dbdb:mysql');
        $this->setDescription('dbdb-mysql-description');
        $this->setHelp('help..........');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Executing...' . self::class);

        $this->dbdb();
        $this->create('foo-mysql5', '5.7.31', '3306');
        $this->start('foo-mysql5');
        $this->stop('foo-mysql5');
        $this->restart('foo-mysql5');
        $this->port('foo-mysql5');
        $this->delete('foo-mysql5');

        $this->createStart('foo-mysql5', '5.7.31', '3306');
        $this->delete('foo-mysql5');
        $this->dbdb();

        return 0;
    }

    private function dbdb()
    {
        $file = self::DBDB_SCRIPT;
        $command = "$file";
        exec($command, $output, $code);

        var_dump($code);
        var_dump($output);
    }

    private function create(string $name, string $version, string $port)
    {
        $file = self::CREATE_SCRIPT;
        $command = "$file $name $version $port";
        exec($command, $output, $code);

        var_dump($code);
        var_dump($output);
    }

    private function createStart(string $name, string $version, string $port)
    {
        $file = self::CREATE_START_SCRIPT;
        $command = "$file $name $version $port";
        exec($command, $output, $code);

        var_dump($code);
        var_dump($output);
    }

    private function start(string $name)
    {
        $file = self::START_SCRIPT;
        $command = "$file $name";
        exec($command, $output, $code);

        var_dump($code);
        var_dump($output);
    }

    private function stop(string $name)
    {
        $file = self::STOP_SCRIPT;
        $command = "$file $name";
        exec($command, $output, $code);

        var_dump($code);
        var_dump($output);
    }

    private function restart(string $name)
    {
        $file = self::RESTART_SCRIPT;
        $command = "$file $name";
        exec($command, $output, $code);

        var_dump($code);
        var_dump($output);
    }

    private function port(string $name)
    {
        $file = self::PORT_SCRIPT;
        $command = "$file $name";
        exec($command, $output, $code);

        var_dump($code);
        var_dump($output);
    }

    private function delete(string $name)
    {
        $file = self::DELETE_SCRIPT;
        $command = "$file $name";
        exec($command, $output, $code);

        var_dump($code);
        var_dump($output);
    }
}
