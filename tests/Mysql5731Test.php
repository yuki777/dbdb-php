<?php

namespace DbDbPhp\Composer;

use PHPUnit\Framework\TestCase;
use Composer\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use DbDbPhp\Composer\Commands\Mysql;
use DbDbPhp\Composer\Commands\DbDbList;
use DbDbPhp\Composer\Commands\DbDbVersion;

class Mysql5731Test extends TestCase
{
    public function testBasic()
    {
        $type = 'mysql';
        $version = '5.7.31';

        $application = new Application();
        $application->add(new Mysql());
        $application->add(new DbDbList());
        $application->add(new DbDbVersion());
        $application->setAutoExit(false);

        $listTester = new CommandTester($application->find("dbdb:list"));
        $versionTester = new CommandTester($application->find("dbdb:version"));
        $dbTester = new CommandTester($application->find("dbdb:$type"));

        // Generate random name
        $dbName = "dbdb-php-test-$type-" . md5(microtime(true));

        // Version
        fwrite(STDERR, "Show version of dbdb" . PHP_EOL);
        $this->assertEquals(0, $versionTester->execute([]));
        $this->assertStringContainsString('"dbdb-php"', $versionTester->getDisplay());
        $this->assertStringContainsString('"dbdb"', $versionTester->getDisplay());

        // Create
        fwrite(STDERR, "Create database $dbName" . PHP_EOL);
        $this->assertEquals(0, $dbTester->execute(["action" => "create", "--db-name" => $dbName, "--db-version" => $version, "--db-port" => "random"]));

        // List
        fwrite(STDERR, "Show databases" . PHP_EOL);
        $this->assertEquals(0, $listTester->execute([]));
        $this->assertStringContainsString($dbName, $listTester->getDisplay());

        // Start
        fwrite(STDERR, "Start database $dbName" . PHP_EOL);
        $this->assertEquals(0, $dbTester->execute(["action" => "start", "--db-name" => $dbName]));

        // Restart
        fwrite(STDERR, "Restart database $dbName" . PHP_EOL);
        $this->assertEquals(0, $dbTester->execute(["action" => "restart", "--db-name" => $dbName]));

        // Port
        fwrite(STDERR, "Show port of database $dbName" . PHP_EOL);
        $this->assertEquals(0, $dbTester->execute(["action" => "port", "--db-name" => $dbName]));

        // Stop
        fwrite(STDERR, "Stop database $dbName" . PHP_EOL);
        $this->assertEquals(0, $dbTester->execute(["action" => "stop", "--db-name" => $dbName]));

        // Delete
        fwrite(STDERR, "Delete database $dbName" . PHP_EOL);
        $this->assertEquals(0, $dbTester->execute(["action" => "delete", "--db-name" => $dbName]));

        // List
        fwrite(STDERR, "Show databases" . PHP_EOL);
        $this->assertEquals(0, $listTester->execute([]));
        $this->assertStringNotContainsString($dbName, $listTester->getDisplay());

        // Create and start
        fwrite(STDERR, "Create and start database $dbName" . PHP_EOL);
        $this->assertEquals(0, $dbTester->execute(["action" => "create-start", "--db-name" => $dbName, "--db-version" => $version, "--db-port" => "random"]));

        // Delete
        fwrite(STDERR, "Delete database $dbName" . PHP_EOL);
        $this->assertEquals(0, $dbTester->execute(["action" => "delete", "--db-name" => $dbName]));

        // List
        fwrite(STDERR, "Show databases" . PHP_EOL);
        $this->assertEquals(0, $listTester->execute([]));
        $this->assertStringNotContainsString($dbName, $listTester->getDisplay());
    }
}
