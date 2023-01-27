<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Items;

use Jonathanrixhon\CliWorkspaceSwitcher\Models\Workspace as WorkspaceModel;

class Workspace
{
    public $id;
    public $name;
    public $path;
    public $ignored;

    public function __construct($workspace, $id = null)
    {
        $this->name = $workspace['name'];
        $this->path = $workspace['path'];
        $this->ignored = $workspace['ignored'] ?? [];
        $this->id = $id;
    }

    public function removeIgnored($name)
    {
        $jsonContent = getConfig();
        $ignoredIndex = array_search($name, array_column($this->ignored, 'name'));
        $jsonContent['workspaces'][$this->id]['ignored'] = array_values($jsonContent['workspaces'][$this->id]['ignored']);

        unset($jsonContent['workspaces'][$this->id]['ignored'][$ignoredIndex]);

        WorkspaceModel::save($jsonContent);
    }
}
