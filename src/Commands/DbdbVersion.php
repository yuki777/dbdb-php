<?php

namespace DbdbPhp\Composer\Commands;

use Composer\InstalledVersions;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbdbVersion extends MysqlBase
{
    const PACKAGE = 'yuki777/dbdb-php';
    protected function configure(): void
    {
        $this->setName('dbdb:version');
        $this->setDescription('Displays dbdb-php version');

        $this->addUsage('dbdb:version');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = [
            'dbdb-php' => $this->getVersion(),
            'dbdb' => $this->getDbDbVersion(),
        ];
        $output->writeln(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return 0;
    }

    private function getVersion()
    {
        $packageName = self::PACKAGE;

        if (InstalledVersions::isInstalled($packageName)) {
            return InstalledVersions::getVersion($packageName);
        }

        return null;
    }

    private function getDbDbVersion()
    {
        $packageName = self::PACKAGE;
        $fileName = 'dbdb/VERSION';

        if (! InstalledVersions::isInstalled($packageName)) {
            return null;
        }

        $installPath = InstalledVersions::getInstallPath($packageName);
        $filePath = $installPath . '/' . $fileName;
        if (! file_exists($filePath)) {
            return null;
        }

        if (! is_readable($filePath)) {
            return null;
        }

        return trim(file_get_contents($filePath));
    }
}
