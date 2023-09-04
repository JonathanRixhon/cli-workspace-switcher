<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns;

use Symfony\Component\Console\Question\ChoiceQuestion;
use Jonathanrixhon\CliWorkspaceSwitcher\Models\Workspace;

trait HasWorkspaceSelector
{
    protected function selectWorkspace(string $text): ?Workspace
    {
        $workspaces = Workspace::all();
        $workspaceName = $this->multiChoice($text, $this->workspaceNames($workspaces), true);
        
        if ($workspaceName === 'Cancel') 
        {
            $this->io->text('Command cancelled');
            return null;
        };
        
        return getFiltered($workspaces, ['name' => $workspaceName])[0];
    }
    
    protected function workspaceNames($workspaces){
        return array_map(fn($workspace) => $workspace->name, $workspaces);
    }
}
