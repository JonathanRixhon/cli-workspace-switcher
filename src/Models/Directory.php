<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Models;

use Jonathanrixhon\CliWorkspaceSwitcher\Items\Workspace;
use Jonathanrixhon\CliWorkspaceSwitcher\Items\Directory as DirectoryItem;

class Directory
{

    public static function get(Workspace $workspace, $name = ''): DirectoryItem
    {
        foreach (self::all($workspace) as $directory) {
            if ($directory->name === $name) {
                return $directory;
            }
        }
    }
    public static function all(Workspace $workspace): array
    {
        $directories = [];
        $ignored = $workspace->ignored ?? [];

        foreach (array_diff(scandir($workspace->path), array('.', '..', '.DS_Store')) as $directory) {
            $dirItem = new DirectoryItem($workspace->path . '/' . $directory);
            if (array_search($dirItem->path, array_column($ignored, 'path')) === false) $directories[] = $dirItem;
        }

        return $directories;
    }

    public static function only($value = null, $index_key = null, Workspace $workspace = null): array
    {
        return array_column(self::all($workspace), $value, $index_key);
    }
}
