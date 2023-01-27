<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces;

use Jonathanrixhon\CliWorkspaceSwitcher\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Jonathanrixhon\CliWorkspaceSwitcher\Models\Directory;
use Jonathanrixhon\CliWorkspaceSwitcher\Models\Workspace;
use Jonathanrixhon\CliWorkspaceSwitcher\Services\InputOutput;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns\HasMultipleChoice;

class WorkspaceConfig extends Command
{
    use HasMultipleChoice;

    protected $configFile;
    protected $input;
    protected $output;
    protected $io;
    protected $arguments;
    protected $errors = [];
    protected $authorizedActions = [
        'add',
        'ignore',
        'removeIgnored',
        'reset',
        'remove',
    ];
    /**
     * The name of the command (the part after "bin/demo").
     *
     * @var string
     */
    protected static $defaultName = 'workspaces:config';

    /**
     * The command description shown when running "php bin/demo list".
     *
     * @var string
     */
    protected static $defaultDescription = 'Configure the application';

    protected function configure(): void
    {
        $this
            ->addArgument('action', InputArgument::REQUIRED, 'Action you want to accomplish (rename, add, reset)');
    }

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
        $this->io = new InputOutput($this->input, $output);
        $action = $input->getArgument('action');
        $this->configFile = File::ensureFileExists($GLOBALS['root'] . '/config.json');

        if (!in_array($action, $this->authorizedActions)) {
            $this->io->wrong('Please enter a valid action argument');
            return Command::FAILURE;
        }

        $this->$action();

        return Command::SUCCESS;
    }

    protected function add()
    {
        $title = 'This command allows you to add workspaces';

        $stop = false;
        $this->io->title($title);

        while (!$stop) {

            $name = $this->io->ask('Please add a workspace name');
            if (!$name) {
                $path = $this->io->wrong('Please add a name');
                $stop = true;
                return Command::FAILURE;
            }

            $path = $this->io->ask('Please add a workspace path');
            if (!file_exists($path)) {
                $path = $this->io->wrong('Please add a valid path.');
                $stop = true;
                return Command::FAILURE;
            }

            Workspace::create([
                'name' => $name,
                'path' => $path,
            ]);

            $stop = !$this->io->confirm('Add more workspaces ?');
        }
    }

    protected function remove()
    {
        $title = 'This command allows you to remove workspaces';
        $this->io->title($title);

        $workspaceName = $this->multiChoice('Please choose a wokspace to remove', Workspace::only('name'), true);
        if ($workspaceName === 'Cancel') return $this->io->text('Command cancelled');
        $workspace = Workspace::get($workspaceName);
        if (Workspace::remove($workspace)) $this->io->right('The workspace ' . $workspace->name . 'Has been removed');
    }

    protected function reset()
    {
        $title = 'This command allows you to remove all workspaces';
        $this->io->title($title);

        if ($this->io->confirm('Are you sure you want to remove all workspaces ?')) {
            Workspace::remove(null, true);
            $this->io->right('All workspaces have been removed');
        } else {
            $this->io->right('Command cancelled');
        }
    }

    protected function ignore()
    {
        $title = 'This command allows you to ignore certain files or directories';
        $this->io->title($title);
        $stop = false;

        $workspaceName = $this->multiChoice('Please choose a wokspace you want to configure', Workspace::only('name'), true);
        if ($workspaceName === 'Cancel') return $this->io->text('Command cancelled');

        while (!$stop) {
            $workspace = Workspace::get($workspaceName);

            $directoryName = $this->multiChoice('Which directory do you want to ignore', Directory::only('name', null, $workspace), true);
            if ($directoryName === 'Cancel') return $this->io->text('Command cancelled');
            $directory = Directory::get($workspace, $directoryName);
            Workspace::ignore($workspaceName, $directory);

            $stop = !$this->io->confirm('You want to add more workspace to ignore ?');
        }
    }
    protected function removeIgnored()
    {
        $title = 'This command allows you to remove ignored directories or files';
        $this->io->title($title);
        $stop = false;

        $workspaceName = $this->multiChoice('Please choose a wokspace you want to remove ignored directories or files', Workspace::only('name'), true);
        if ($workspaceName === 'Cancel') return $this->io->text('Command cancelled');

        while (!$stop) {
            $workspace = Workspace::get($workspaceName);

            $ignoredName = $this->multiChoice('Please choose a wokspace you want to remove ignored directories or files', array_column($workspace->ignored, 'name'), true);
            if ($ignoredName === 'Cancel') return $this->io->text('Command cancelled');
            $workspace->removeIgnored($ignoredName);

            $stop = !$this->io->confirm('You want to remove workspaces from the ignored ones ?');
        }


        //$ignored = $this->multiChoice('Which directory do you want to remove from ignored', Directory::only('ignored', null, $workspace), true);
        //if ($directoryName === 'Cancel') return $this->io->text('Command cancelled');
        //$directory = Directory::get($workspace, $directoryName);
        //Workspace::removeIgnored($workspace);
    }
}
