<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Models;

use SplFileInfo;
use Jonathanrixhon\CliWorkspaceSwitcher\Models\Workspace;

class Directory
{
    public string $path;
    public SplFileInfo $file;
    public string $name;
    public ?Workspace $workspace;

    public function __construct($path, $workspace = null)
    {
        $this->path = $path;
        $this->file = new SplFileInfo($path);
        $this->name = $this->file->getBasename();
        $this->workspace = $workspace;
        $this->path = $path;
    }

    public function open()
    {
        shell_exec(sprintf('code -n %s', $this->path));
        if ($this->file->isDir()) shell_exec(sprintf('open -a iTerm %s', $this->path));
    }
    
    public static function all($path, $workspace = null){
        $directories = directoriesFrom($path);
        return array_map(fn($dir) => new static($dir, $workspace), $directories);
    }
}
