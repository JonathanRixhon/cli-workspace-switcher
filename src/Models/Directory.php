<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Models;

use Jonathanrixhon\CliWorkspaceSwitcher\Items\Directory as DirectoryItem;

class Directory
{

    public static function get($path, $name = ''): DirectoryItem
    {
        foreach (self::all($path) as $directory) {
            if ($directory->name === $name) {
                return $directory;
            }
        }
    }
    public static function all($path): array
    {
        $directories = [];
        foreach (array_diff(scandir($path), array('.', '..', '.DS_Store')) as $directory) {
            $directories[] = new DirectoryItem($path . '/' . $directory);
        }

        return $directories;
    }

    public static function only($value = null, $index_key = null, $path = ''): array
    {
        return array_column(self::all($path), $value, $index_key);
    }
}
