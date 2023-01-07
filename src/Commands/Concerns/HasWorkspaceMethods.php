<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Commands\Concerns;

trait HasWorkspaceMethods
{
    function searchForWorkspaceName($name)
    {
        foreach (getConfig()['workspaces'] ?? [] as $key => $workspace) {
            if ($workspace['name'] === $name) {
                return $key;
            }
        }

        return null;
    }
}
