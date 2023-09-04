<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Models;

use Jonathanrixhon\CliWorkspaceSwitcher\File;
use Jonathanrixhon\CliWorkspaceSwitcher\Models\Directory;
use Jonathanrixhon\CliWorkspaceSwitcher\Items\Workspace as WorkspaceItem;

class Workspace extends Model
{
    public static $table = 'workspaces';

    public function directories()
    {
        return Directory::all($this->path, $this);
    }
}