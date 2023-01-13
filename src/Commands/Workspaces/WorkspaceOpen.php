<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces;

use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns\HasMultipleChoice;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns\HasWorkspaceMethods;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Jonathanrixhon\CliWorkspaceSwitcher\Services\InputOutput;

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
        $this->workspaces = getConfig()['workspaces'] ?? [];

        $workspaceName = $this->multiChoice('Which Workspace do you want to open ?', getOnlyKeys($this->workspaces, 'name'), true);
        $this->openDirectory($workspaceName);

        if ($workspaceName === 'Cancel') {
            $this->io->wrong('Command cancelled');
            return Command::FAILURE;
        };


        return Command::SUCCESS;
    }
}
