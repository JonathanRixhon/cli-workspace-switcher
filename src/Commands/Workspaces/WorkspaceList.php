<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces;

use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Command;
use Jonathanrixhon\CliWorkspaceSwitcher\Models\Workspace;


class WorkspaceList extends Command
{
    /**
     * The name of the command (the part after "bin/demo").
     *
     * @var string
     */
    protected static $defaultName = 'workspaces:list';

    /**
     * The command description shown when running "php bin/demo list".
     *
     * @var string
     */
    protected static $defaultDescription = 'Lists the workspaces';

    protected function handle(): int
    {
        $this->io->table(['Names', 'Paths'], $this->getTable(Workspace::all()));
        return $this->command::SUCCESS;
    }

    protected function getTable($workspaces)
    {
        return array_map(function ($workspace) {
            return [$workspace->name, $workspace->path];
        }, $workspaces);
    }
}
