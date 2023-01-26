<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Models;

use Jonathanrixhon\CliWorkspaceSwitcher\Items\Workspace as WorkspaceItem;

class Workspace
{
    public static function get(string $name = '') :WorkspaceItem
    {
        foreach (static::all() ?? [] as $key => $workspace) {
            if ($workspace->name === $name) {
                return $workspace;
            }
        }
    }

    public static function all(): array
    {
        $workspaces = [];
        foreach (getconfig()['workspaces'] as $workspace) {
            $workspaces[] = new WorkspaceItem($workspace);
        }

        return $workspaces;
    }

    public static function only($value = null, $index_key = null): array
    {
        return array_column(self::all(), $value, $index_key);
    }

    public static function open($workspaceName = ''): array
    {
        $workspace = self::get($workspaceName);
        return [];
    }
}
