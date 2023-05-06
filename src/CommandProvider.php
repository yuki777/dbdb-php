<?php

namespace DbDbPhp\Composer;

use Composer\Plugin\Capability\CommandProvider as CommandProviderCapability;

class CommandProvider implements CommandProviderCapability
{
    public function getCommands()
    {
        return [
            new Commands\DbDbVersion(),
            new Commands\DbDbList(),
            new Commands\Mongodb(),
            new Commands\Mysql(),
            new Commands\Postgresql(),
            new Commands\Redis(),
        ];
    }
}
