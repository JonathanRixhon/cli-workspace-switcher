<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Items;

use Jonathanrixhon\CliWorkspaceSwitcher\Models\Directory;

class Workspace
{
    public $id;
    public $name;
    public $path;

    public function __construct($workspace, $id = null)
    {
        $this->name = $workspace['name'];
        $this->path = $workspace['path'];
        $this->id = $id;
    }

    public function getDirectories()
    {
        return Directory::all($this->path);
    }
}
