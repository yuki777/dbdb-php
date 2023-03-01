<?php

namespace DbdbPhp\Composer\Commands;

use Composer\Command\BaseCommand;

class MysqlBase extends BaseCommand
{
    protected function exec(string $command)
    {
        exec($command, $response, $code);

        return [
            'command' => $command,
            'response' => implode("\n", $response),
            'code' => $code,
        ];
    }
}
