<?php

namespace DbdbPhp\Composer;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;

class CommandProvider implements CommandProviderCapability
{
    public function getCommands()
    {
        return [
            new Commands\DbdbList(),
            new Commands\MysqlCreate(),
            new Commands\MysqlStart(),
            new Commands\MysqlStop(),
            new Commands\MysqlRestart(),
            new Commands\MysqlCreateStart(),
            new Commands\MysqlPort(),
            new Commands\MysqlDelete(),
        ];
    }
}
