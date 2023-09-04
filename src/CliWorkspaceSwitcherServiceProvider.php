<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher;

use Jonathanrixhon\CliWorkspaceSwitcher\CliWorkspaceSwitcher;

class CliWorkspaceSwitcherServiceProvider
{
    public function __construct()
    {
        CliWorkspaceSwitcher::initDatabase();
    }
}
