<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher;

use SplFileInfo;

class File
{
    public static function ensureFileExists(string $path)
    {
        if (!file_exists($path)) {
            $file = fopen($path, "w");
            fclose($file);
        }

        return new SplFileInfo($path);
    }
}
