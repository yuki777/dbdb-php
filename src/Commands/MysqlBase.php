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
            'response' => json_encode(json_decode(implode("\n", $response), true), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'code' => $code,
        ];
    }
}
