#!/usr/bin/env php
<?php
$GLOBALS['root'] = dirname(__DIR__);

if (!is_file(sprintf('%s/vendor/autoload.php', $GLOBALS['root']))) {
    $GLOBALS['root'] = dirname(__DIR__, 4);
}

require sprintf('%s/vendor/autoload.php', $GLOBALS['root']);

use Symfony\Component\Console\Application;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces\WorkspaceOpen;
use Jonathanrixhon\CliWorkspaceSwitcher\CliWorkspaceSwitcherServiceProvider;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces\WorkspaceList;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces\Config\WorkspaceConfig;
use Jonathanrixhon\CliWorkspaceSwitcher\Commands\Workspaces\Config\WorkspaceInstall;

$application = new Application();
$serviceProvider = new CliWorkspaceSwitcherServiceProvider();

$application->add(new WorkspaceInstall());
$application->add(new WorkspaceConfig());
$application->add(new WorkspaceList());
$application->add(new WorkspaceOpen());

$application->run();
