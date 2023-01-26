<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Items;

use Jonathanrixhon\CliWorkspaceSwitcher\Models\Directory;

class Workspace
{
    public $name;
    public $path;

    public function __construct($workspace)
    {
        $this->name = $workspace['name'];
        $this->path = $workspace['path'];
    }

    public function open()
    {
        // $directories = $this->getWorkspaceDirectories($this->workspaces[$this->searchForWorkspaceName($workspaceName)]['path']);
        // $directoryName = $this->multiChoice('Which directory do you want to open ?', $directories->choices);
        // $this->work($directories->all[$directories->indexes[$directoryName]]->getPathname());


        // var_dump($this);
        // die();
    }

    public function getDirectories()
    {
        return Directory::all($this->path);
    }
}
