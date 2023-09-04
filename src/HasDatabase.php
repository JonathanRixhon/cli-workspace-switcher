<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher;

use Jonathanrixhon\CliWorkspaceSwitcher\Database\Database;

trait HasDatabase
{
    /**
     * The application's database
     */
    protected static Database $database;

    /**
     * Init the database
     */
    public static function initDatabase()
    {
        static::$database = new Database();
    }

    /**
     * The database
     */
    public static function database(): Database
    {
        return static::$database;
    }
}
