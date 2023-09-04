<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands;

use Jonathanrixhon\CliWorkspaceSwitcher\CliWorkspaceSwitcher;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Jonathanrixhon\CliWorkspaceSwitcher\Services\InputOutput;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns\HasMultipleChoice;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Inteface\Command as IntefaceCommand;

class Command extends BaseCommand
{
    use HasMultipleChoice;

    protected $command;
    protected $errors = [];
    protected $input;
    protected $output;
    protected $io;

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
         $this->command = new SymfonyCommand();
         CliWorkspaceSwitcher::setInputOutput($this->io);
         
         return $this->handle();
     }

     protected function handle(): int
     {
        return $this->command::SUCCESS;
     }
}
