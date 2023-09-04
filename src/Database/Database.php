<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher\Database;

use Jonathanrixhon\CliWorkspaceSwitcher\CliWorkspaceSwitcher;
use Jonathanrixhon\CliWorkspaceSwitcher\File;

class Database
{
    protected static $pdo;
    protected static $io;

    public function __construct()
    {
        $this->connect();
    }

    /**
     * Creates Sqlite database if not exists and run migrations
     */
    public static function create()
    {
        File::ensureFileExists(db_path());
        self::runMigrations();
    }

    /**
     * Get the migrations
     */
    public static function runMigrations()
    {
        CliWorkspaceSwitcher::io()->title('Running migrations');
        $allTables = self::allTables();

        foreach (self::migrations() as $migration) {
            if (in_array($migration['table'], $allTables)) {
                CliWorkspaceSwitcher::io()->text('The table ' . $migration['table'] . ' already exists.');
                continue;
            }

            $query = 'CREATE TABLE ' . $migration['table'] . '(';

            foreach ($migration['columns'] as $column => $type) {
                $query .= $column . ' ' . $type . ', ';
            }

            if (isset($migration['fk'])) {
                $query .= 'FOREIGN KEY (' . $migration['fk']['column'] . ') REFERENCES ' . $migration['fk']['references']['table'] . '(' . $migration['fk']['references']['column'] . ')';
            }

            $query = rtrim($query, ', ');
            $query .= ');';

            self::runQuery($query);
            CliWorkspaceSwitcher::io()->text('The table ' . $migration['table'] . ' has been created');
        }
        
        CliWorkspaceSwitcher::io()->success('Migrations finished');
    }

    /**
     * Get the migrations
     */
    public static function migrations()
    {
        return include migrations_path();
    }

    /**
     * Get the migrations
     */
    public static function runQuery(string $query): array
    {
        $connexion = self::pdo();
        $results = $connexion->prepare($query);
        $results->setFetchMode(\PDO::FETCH_ASSOC);
        $results->execute();

        return $results->fetchAll();
    }

    /**
     * return in instance of the PDO object that connects to the SQLite database
     */
    public function connect(): void
    {
        if (self::$pdo == null) {
            self::$pdo = new \PDO("sqlite:" . db_path());
        }
    }

    /**
     * Get the pdo connection
     */
    public static function pdo()
    {
        return self::$pdo;
    }

    /**
     * Get all the database Tables
     */
    public static function allTables()
    {
        $results = self::runQuery("SELECT name FROM sqlite_schema WHERE type = 'table' AND name NOT LIKE 'sqlite_%'");
        return array_column($results, 'name');
    }
}
