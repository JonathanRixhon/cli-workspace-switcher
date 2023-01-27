<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Models;

use Jonathanrixhon\CliWorkspaceSwitcher\File;
use Jonathanrixhon\CliWorkspaceSwitcher\Items\Directory;
use Jonathanrixhon\CliWorkspaceSwitcher\Items\Workspace as WorkspaceItem;

class Workspace
{
    public static function get(string $name = ''): ?WorkspaceItem
    {
        foreach (static::all() ?? [] as $workspace) {
            if ($workspace->name === $name) {
                return $workspace;
            }
        }

        return null;
    }

    public static function all(): array
    {
        $workspaces = [];
        foreach (getconfig()['workspaces'] as $key => $workspace) {
            $workspaces[] = new WorkspaceItem($workspace, $key);
        }

        return $workspaces;
    }

    public static function only($value = null, $index_key = null): array
    {
        return array_column(self::all(), $value, $index_key);
    }

    public static function remove($workspaceItem, $removeAll = false)
    {
        $jsonContent = getConfig();

        if ($removeAll) {
            $jsonContent['workspaces'] = [];
            self::save($jsonContent);
            return true;
        }

        unset($jsonContent['workspaces'][$workspaceItem->id]);
        self::save($jsonContent);

        return true;
    }

    public static function ignore(string $workspaceName, Directory $directory)
    {
        $workspace = self::get($workspaceName);
        $jsonContent = getConfig();

        $jsonContent['workspaces'][$workspace->id]['ignored'][] = [
            'name' => $directory->name,
            'path' => $directory->path,
        ];

        self::save($jsonContent);
    }

    public static function create($workspace = [])
    {
        $jsonContent = getConfig();
        $workspaces = $jsonContent['workspaces'] ?? [];
        $workspaceItem = self::get($workspace['name']);

        if (!is_null($workspaceItem)) {
            $workspaces[$workspaceItem->id] = $workspace;
        } else {
            $workspaces[] = $workspace;
        }

        $jsonContent['workspaces'] = $workspaces;
        self::save($jsonContent);
    }

    public static function save($newJson)
    {
        $jsonContent = array_merge($jsonContent ?? [], $newJson);
        $file = fopen(self::getconfigFile()->getPathName(), 'w');
        fwrite($file, json_encode($jsonContent));
        fclose($file);
    }

    protected static function getConfigFile()
    {
        return File::ensureFileExists($GLOBALS['root'] . '/config.json');
    }
}
