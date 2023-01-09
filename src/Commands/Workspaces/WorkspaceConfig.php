<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces;

use Jonathanrixhon\CliWorkspaceSwitcher\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Jonathanrixhon\CliWorkspaceSwitcher\Services\InputOutput;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns\HasMultipleChoice;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns\HasWorkspaceMethods;

class WorkspaceConfig extends Command
{
    use HasMultipleChoice, HasWorkspaceMethods;

    protected $configFile;
    protected $input;
    protected $output;
    protected $io;
    protected $arguments;
    protected $errors = [];
    protected $authorizedActions = [
        'add',
        'reset',
        'remove'
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

            $this->addWorkSpace([
                'name' => $name,
                'path' => $path,
            ]);

            $stop = !$this->io->confirm('Add more workspaces ?');
        }
    }

    public function addWorkSpace($workspace)
    {
        $jsonContent = getConfig();
        $workspaces = $jsonContent['workspaces'] ?? [];
        $this->searchForWorkspaceName($workspace['name']);
        $index = $this->searchForWorkspaceName($workspace['name']);

        if (!is_null($index)) {
            $workspaces[$index] = $workspace;
        } else {
            $workspaces[] = $workspace;
        }

        $jsonContent['workspaces'] = $workspaces;
        $this->save($jsonContent);
    }

    protected function remove()
    {
        $title = 'This command allows you to remove workspaces';
        $this->io->title($title);

        $workspaces = getConfig()['workspaces'];
        $this->removeWorkspace($this->multiChoice('Please choose a wokspace to remove', getOnlyKeys($workspaces, 'name'), true));
    }

    protected function reset()
    {
        $title = 'This command allows you to remove all workspaces';
        $this->io->title($title);

        if ($this->io->confirm('Are you sure you want to remove all workspaces ?')) {
            $this->removeWorkspace('all');
        } else {
            $this->io->right('Command cancelled');
        }
    }

    protected function removeWorkspace($workspace)
    {
        $jsonContent = getConfig();

        if ($workspace === 'Cancel') return $this->io->text('Command cancelled');
        if ($workspace === 'all') {
            unset($jsonContent['workspaces']);
            $this->save($jsonContent);
            return $this->io->right(sprintf('All workspaces removed successfully', $workspace));
        } else {
            unset($jsonContent['workspaces'][$this->searchForWorkspaceName($workspace)]);
            $this->save($jsonContent);
            return $this->io->right(sprintf('The workspace %s has been deleted successfully', $workspace));
        };
    }

    protected function save($newJson)
    {
        $jsonContent = array_merge($jsonContent ?? [], $newJson);
        $file = fopen($this->configFile->getPathName(), 'w');
        fwrite($file, json_encode($jsonContent));
        fclose($file);
    }
}
