<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Jonathanrixhon\CliWorkspaceSwitcher\Services\InputOutput;

class WorkspaceList extends Command
{
    protected $io;
    protected $input;
    protected $output;
    /**
     * The name of the command (the part after "bin/demo").
     *
     * @var string
     */
    protected static $defaultName = 'workspace:list';

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

        $this->io->listing(array_keys(getConfig()['workspaces'] ?? []));


        return Command::SUCCESS;
    }
}
