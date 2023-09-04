<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Models;

use Jonathanrixhon\CliWorkspaceSwitcher\CliWorkspaceSwitcher;

class Model
{
    protected $attributes = [];

    public static $table;

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    public function __get($property)
    {
        if (isset($this->attributes[$property])) {
            return $this->attributes[$property];
        }

        return null;
    }

    /*
    * Model's item functions
    */
    public function getAttributes(array $attributes = [])
    {
        if (count($attributes)) {
            foreach ($attributes as $key => $value) {
                return array_intersect($this->attributes, $attributes);
            }
        }

        return $this->attributes;
    }

    public function delete()
    {
        return CliWorkspaceSwitcher::database()->runQuery("DELETE FROM " . static::$table . " WHERE id='" . $this->attributes['id'] . "'");
    }

    /*
    * Model's Static functions
    */

    public static function all(array $selected = []): array
    {
        $selected = count($selected) ? implode(',', $selected) : '*';
        return self::makeArray(CliWorkspaceSwitcher::database()->runQuery('SELECT ' . $selected . ' FROM ' . static::$table));
    }

    public static function create($attributes)
    {
        $attributes = array_map(fn ($attribute) => value_query($attribute), $attributes);
        $columns = implode(',', array_keys($attributes));
        $values = implode(',', $attributes);

        return CliWorkspaceSwitcher::database()->runQuery('INSERT INTO ' . static::$table . ' (' . $columns . ') VALUES (' . $values . ')');
    }

    protected static function makeArray($results): array
    {
        $array = array_map(function ($result) {
            return new static($result);
        }, $results);

        return $array;
    }
}
