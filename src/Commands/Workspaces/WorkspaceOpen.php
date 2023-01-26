<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Jonathanrixhon\CliWorkspaceSwitcher\Models\Directory;
use Jonathanrixhon\CliWorkspaceSwitcher\Models\Workspace;
use Jonathanrixhon\CliWorkspaceSwitcher\Services\InputOutput;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns\HasMultipleChoice;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns\HasWorkspaceMethods;

class WorkspaceOpen extends Command
{
    use HasMultipleChoice, HasWorkspaceMethods;

    protected $io;
    protected $input;
    protected $output;
    protected $currentWorkspace;
    protected $workspaces;
    /**
     * The name of the command (the part after "bin/demo").
     *
     * @var string
     */
    protected static $defaultName = 'workspace';

    /**
     * The command description shown when running "php bin/demo list".
     *
     * @var string
     */
    protected static $defaultDescription = 'List all workspaces';

    /**
     * Execute the command
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int 0 if everything went fine, or an exit code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;
        $this->io = new InputOutput($this->input, $this->output);

        $workspaceName = $this->multiChoice('Which workspace do you want to open ?', Workspace::only('name'), true);
        $workspace = Workspace::get($workspaceName);

        if ($workspaceName === 'Cancel') {
            $this->io->wrong('Command cancelled');
            return Command::FAILURE;
        };

        $directoryName = $this->multiChoice('Which directory do you want to open ?', Directory::only('name', null, $workspace->path), true);
        $directory = Directory::get($workspace->path, $directoryName);

        $directory->open();



        return Command::SUCCESS;
    }
}
