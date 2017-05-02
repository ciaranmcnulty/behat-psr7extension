<?php


namespace Cjm\Behat\Psr7Extension;

/**
 * Can create a Psr7App from a config string
 */
interface Psr7AppLoader
{
    public function load(string $config) : Psr7App;
}
