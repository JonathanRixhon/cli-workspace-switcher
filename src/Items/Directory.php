<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Items;

use SplFileInfo;

class Directory
{
    public $file;
    public $path;
    public $name;

    public function __construct($path)
    {
        $this->file = new SplFileInfo($path);
        $this->name = $this->file->getBasename();
        $this->path = $path;
    }

    public function open()
    {
        shell_exec(sprintf('code -n %s', $this->path));

        if ($this->file->isDir()) shell_exec(sprintf('open -a iTerm %s', $this->path));
    }
}
