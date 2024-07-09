<?php

namespace App\Actions;

abstract class Actionable
{
    public abstract function handle();


    /**
     * Run the action
     * 
     * @see handle
     */
    public static function run(...$arguments)
    {
        return app(static::class)->handle(...$arguments);
    }
}