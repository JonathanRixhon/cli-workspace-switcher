<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces\Config;

use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Command;
use Jonathanrixhon\CliWorkspaceSwitcher\CliWorkspaceSwitcher;


class WorkspaceInstall extends Command
{
    /**
     * The name of the command (the part after "bin/demo").
     *
     * @var string
     */
    protected static $defaultName = 'workspaces:install';

    /**
     * The command description shown when running "php bin/demo list".
     *
     * @var string
     */
    protected static $defaultDescription = 'Install the application';

    protected function handle(): int
    {
        $database = CliWorkspaceSwitcher::database()->create();
        return $this->command::SUCCESS;
    }
}
