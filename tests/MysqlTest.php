<?php

namespace DbdbPhp\Composer;

use PHPUnit\Framework\TestCase;
use Composer\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use DbdbPhp\Composer\Commands\MysqlCreate;
use DbdbPhp\Composer\Commands\MysqlCreateStart;
use DbdbPhp\Composer\Commands\MysqlDelete;
use DbdbPhp\Composer\Commands\MysqlPort;
use DbdbPhp\Composer\Commands\MysqlRestart;
use DbdbPhp\Composer\Commands\MysqlStart;
use DbdbPhp\Composer\Commands\MysqlStop;

class MysqlTest extends TestCase
{
    public function testBasic()
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->add(new MysqlCreate());
        $application->add(new MysqlCreateStart());
        $application->add(new MysqlDelete());
        $application->add(new MysqlPort());
        $application->add(new MysqlRestart());
        $application->add(new MysqlStart());
        $application->add(new MysqlStop());

        // Generate random name
        $dbName = 'dbdb-php-test-mysql-' . md5(microtime(true));

        // Create database
        fwrite(STDERR, "Creating database $dbName" . PHP_EOL);
        $commandTester = new CommandTester($application->find('dbdb:mysql-create'));
        $this->assertEquals(0, $commandTester->execute(["name" => $dbName, "version" => "5.7.31", "port" => "random"]));

        // Start database
        fwrite(STDERR, "Starting database $dbName" . PHP_EOL);
        $commandTester = new CommandTester($application->find('dbdb:mysql-start'));
        $this->assertEquals(0, $commandTester->execute(["name" => $dbName]));

        // Restart database
        fwrite(STDERR, "Restarting database $dbName" . PHP_EOL);
        $commandTester = new CommandTester($application->find('dbdb:mysql-restart'));
        $this->assertEquals(0, $commandTester->execute(["name" => $dbName]));

        // Show port
        fwrite(STDERR, "Showing port of database $dbName" . PHP_EOL);
        $commandTester = new CommandTester($application->find('dbdb:mysql-port'));
        $this->assertEquals(0, $commandTester->execute(["name" => $dbName]));

        // Stop database
        fwrite(STDERR, "Stopping database $dbName" . PHP_EOL);
        $commandTester = new CommandTester($application->find('dbdb:mysql-stop'));
        $this->assertEquals(0, $commandTester->execute(["name" => $dbName]));

        // Delete database
        fwrite(STDERR, "Deleting database $dbName" . PHP_EOL);
        $commandTester = new CommandTester($application->find('dbdb:mysql-delete'));
        $this->assertEquals(0, $commandTester->execute(["name" => $dbName]));

        // Create database, then start
        fwrite(STDERR, "Creating database $dbName, then starting" . PHP_EOL);
        $commandTester = new CommandTester($application->find('dbdb:mysql-create-start'));
        $this->assertEquals(0, $commandTester->execute(["name" => $dbName, "version" => "5.7.31", "port" => "random"]));

        // Delete database
        fwrite(STDERR, "Deleting database $dbName" . PHP_EOL);
        $commandTester = new CommandTester($application->find('dbdb:mysql-delete'));
        $this->assertEquals(0, $commandTester->execute(["name" => $dbName]));
    }
}
