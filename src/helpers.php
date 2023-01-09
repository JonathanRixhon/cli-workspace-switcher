<?php

use Jonathanrixhon\CliWorkspaceSwitcher\File;

function getConfig()
{
    return json_decode(file_get_contents($GLOBALS['root'] . '/config.json'), true);
}

function getOnlyKeys($array, $onlyKeys)
{
    if (is_string($onlyKeys)) return array_column($array, $onlyKeys);

    return array_map(function ($value) use ($onlyKeys) {
        $returnValue = [];
        foreach ($onlyKeys as $key) {
            $returnValue[$key] = $value[$key] ?? null;
        }

        return $returnValue;
    }, $array);
}
