<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns;

use SplFileInfo;
use stdClass;

trait HasWorkspaceMethods
{
    function getWorkspaceDirectories($path)
    {
        if (!$path) return null;
        $directories = new stdClass();
        $directories->all = [];
        $directories->choices = [];

        foreach (array_diff(scandir($path), array('.', '..', '.DS_Store')) as $directory) {
            $directory = new SplFileInfo($path . '/' . $directory);
            $directories->all[] = $directory;
            $directories->choices[] = $directory->getBasename();
        }

        $directories->indexes = array_flip($directories->choices);

        return $directories;
    }

    function searchForWorkspaceName($name)
    {
        foreach (getConfig()['workspaces'] ?? [] as $key => $workspace) {
            if ($workspace['name'] === $name) {
                return $key;
            }
        }

        return null;
    }

    public function getWorkspaceByName($name)
    {
        $workspaces = getConfig()['workspaces'];
        $names = array_column($workspaces, 'name');
        $found_key = array_search($name, $names);

        return $workspaces[$found_key];
    }

    public function getDirectoryByName($directories, $name)
    {
    }

    public function work($path)
    {
        shell_exec(sprintf('code -n %s', $path));
    }
}
