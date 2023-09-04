<?php

function db_path()
{
    return $GLOBALS['root'] . '/src/' . 'database/database.sqlite';
}

function migrations_path()
{
    return $GLOBALS['root'] . '/src/' . 'database/Migrations/migrations.php';
}

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

function value_query($value)
{
    if (is_string($value)) $value = "'$value'";

    return $value;
}

function getFiltered(array $models, array $wheres)
{
    $models = array_filter($models, function ($model) use ($wheres) {
        $validated = [];
        foreach ($wheres as $attribute => $value) {
            if ($model->$attribute === $value) {
                $validated[] = true;
            }
        }

        return count($validated) === count($wheres);
    });

    return count($models) ? array_values($models) : null;
}

function directoriesFrom(string $path)
{
    $dirs = array_diff(scandir($path), ['..', '.', '.DS_Store']);
    $dirs = array_map(function ($dir) use($path){
        return $path. '/' . $dir;
    }, $dirs);

    return array_values($dirs);
}

function dd($var)
{
    var_dump($var);
    die();
}
