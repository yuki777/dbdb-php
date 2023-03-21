<?php

namespace DbdbPhp\Composer;

use PHPUnit\Framework\TestCase;
use Composer\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use DbdbPhp\Composer\Commands\MysqlCreate;
use DbdbPhp\Composer\Commands\MysqlDelete;
use DbdbPhp\Composer\Commands\MysqlStart;

class MysqlTest extends TestCase
{
    public function testExecute()
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->add(new MysqlCreate());
        $application->add(new MysqlStart());
        $application->add(new MysqlDelete());

        // Generate random name
        $dbName = 'dbdb-php-test-mysql-' . md5(microtime(true));

        // Create database
        $commandTester = new CommandTester($application->find('dbdb:mysql-create'));
        $this->assertEquals(0, $commandTester->execute(["name" => $dbName, "version" => "5.7.31", "port" => "random"]));

        // Start database
        $commandTester = new CommandTester($application->find('dbdb:mysql-start'));
        $this->assertEquals(0, $commandTester->execute(["name" => $dbName]));

        // Delete database
        $commandTester = new CommandTester($application->find('dbdb:mysql-delete'));
        $this->assertEquals(0, $commandTester->execute(["name" => $dbName]));
    }
}
