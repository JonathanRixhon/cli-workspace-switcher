#!/usr/bin/env php
<?php
$GLOBALS['root'] = dirname(__DIR__);

if (!is_file(sprintf('%s/vendor/autoload.php', $GLOBALS['root']))) {
    $GLOBALS['root'] = dirname(__DIR__, 4);
}

require sprintf('%s/vendor/autoload.php', $GLOBALS['root']);

use Symfony\Component\Console\Application;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces\WorkspaceEdit;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces\WorkspaceList;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces\WorkspaceOpen;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces\WorkspaceConfig;

$application = new Application();

$application->add(new WorkspaceConfig());
$application->add(new WorkspaceList());
$application->add(new WorkspaceOpen());

$application->run();
