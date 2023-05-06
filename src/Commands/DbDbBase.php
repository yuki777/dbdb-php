<?php

namespace DbDbPhp\Composer\Commands;

use Composer\Command\BaseCommand;

class DbDbBase extends BaseCommand
{
    protected function exec(string $command)
    {
        exec($command, $response, $code);

        return [
            'command' => $command,
            'response' => json_decode(implode("\n", $response), true),
            'code' => $code,
        ];
    }
}
