<?php

namespace DbDbPhp\Composer;

use PHPUnit\Framework\TestCase;
use Composer\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use DbDbPhp\Composer\Commands\Postgresql;

class PostgresqlTest extends TestCase
{
    public function testBasic()
    {
        $type = 'postgresql';
        $oldVersion = '12.4';
        $newVersion = '13.2';

        $application = new Application();
        $application->setAutoExit(false);
        $application->add(new Postgresql());
        $commandTester = new CommandTester($application->find("dbdb:$type"));

        // Generate random name
        $dbName = "dbdb-php-test-$type-" . md5(microtime(true));

        // Create
        fwrite(STDERR, "Create database $dbName" . PHP_EOL);
        $this->assertEquals(0, $commandTester->execute(["action" => "create", "--db-name" => $dbName, "--db-version" => $oldVersion, "--db-port" => "random"]));

        // Start
        fwrite(STDERR, "Start database $dbName" . PHP_EOL);
        $this->assertEquals(0, $commandTester->execute(["action" => "start", "--db-name" => $dbName]));

        // Restart
        fwrite(STDERR, "Restart database $dbName" . PHP_EOL);
        $this->assertEquals(0, $commandTester->execute(["action" => "restart", "--db-name" => $dbName]));

        // Port
        fwrite(STDERR, "Show port of database $dbName" . PHP_EOL);
        $this->assertEquals(0, $commandTester->execute(["action" => "port", "--db-name" => $dbName]));

        // Stop
        fwrite(STDERR, "Stop database $dbName" . PHP_EOL);
        $this->assertEquals(0, $commandTester->execute(["action" => "stop", "--db-name" => $dbName]));

        // Delete
        fwrite(STDERR, "Delete database $dbName" . PHP_EOL);
        $this->assertEquals(0, $commandTester->execute(["action" => "delete", "--db-name" => $dbName]));

        // Create and start
        fwrite(STDERR, "Create and start database $dbName" . PHP_EOL);
        $this->assertEquals(0, $commandTester->execute(["action" => "create-start", "--db-name" => $dbName, "--db-version" => $newVersion, "--db-port" => "random"]));

        // Delete
        fwrite(STDERR, "Delete database $dbName" . PHP_EOL);
        $this->assertEquals(0, $commandTester->execute(["action" => "delete", "--db-name" => $dbName]));
    }
}
