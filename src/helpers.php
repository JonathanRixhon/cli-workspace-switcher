<?php

use Jonathanrixhon\CliWorkspaceSwitcher\File;

function getConfig()
{
    return json_decode(file_get_contents($GLOBALS['root'] . '/config.json'),true);
}
