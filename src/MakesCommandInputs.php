<?php

namespace Jonathanrixhon\CliWorkspaceSwitcher;

use Jonathanrixhon\CliWorkspaceSwitcher\Services\InputOutput;

trait MakesCommandInputs
{
    protected static InputOutput $io;
    
    /**
     * Set the input output
     */
    public static function setInputOutput(InputOutput $io)
    {
        static::$io = $io;
    }

    /**
     * The input output
     */
    public static function io()
    {
        return static::$io;
    }
}
