<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces;

use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Command;
use Jonathanrixhon\CliWorkspaceSwitcher\Models\Workspace;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns\HasDirectorySelector;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns\HasWorkspaceSelector;

class WorkspaceOpen extends Command
{
    use HasWorkspaceSelector, HasDirectorySelector;
    /**
     * The name of the command (the part after "bin/demo").
     *
     * @var string
     */
    protected static $defaultName = 'workspaces:open';

    /**
     * The command description shown when running "php bin/demo list".
     *
     * @var string
     */
    protected static $defaultDescription = 'Opens a workspace';

    protected function handle(): int
    {
        $this->io->title('This command allows you to open workspaces');
        if (!($workspace = $this->selectWorkspace('Please choose a workspace to open'))) return null;
        if (!($directory = $this->selectDirectory('Please choose a directory to open', $workspace->directories()))) return null;

        $directory->open();

        return $this->command::SUCCESS;
    }
}
