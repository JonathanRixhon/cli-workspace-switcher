<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns;

use Symfony\Component\Console\Question\ChoiceQuestion;
use Jonathanrixhon\CliWorkspaceSwitcher\Models\Workspace;

trait HasDirectorySelector
{
    protected function selectDirectory(string $text, $directories)
    {
        $directoryName = $this->multiChoice($text, $this->directoryNames($directories), true);
        
        if ($directoryName === 'Cancel') 
        {
            $this->io->text('Command cancelled');
            return null;
        };
        
        return getFiltered($directories, ['name' => $directoryName])[0];
    }
    
    protected function directoryNames($directories){
        return array_map(fn($directory) => $directory->name, $directories);
    }
}
