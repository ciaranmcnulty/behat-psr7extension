<?php

namespace Cjm\Behat\Psr7Extension\AppFile;

use Cjm\Behat\Psr7Extension\Psr7App;
use Cjm\Behat\Psr7Extension\Psr7AppFactory;
use Cjm\Behat\Psr7Extension\Psr7AppLoader;

/**
 * Loads an app by reading a file and finding an appropriate factory
 */
class Loader implements Psr7AppLoader
{
    private $factories;

    public function __construct(Psr7AppFactory ...$factories)
    {
        $this->factories = $factories;
    }

    public function load(string $path): Psr7App
    {
        if (!file_exists($path)) {
            throw new LoaderException('No file found at ' . $path);
        }

        if (!($type = include $path)) {
            throw new LoaderException('File at ' . $path . ' did not return');
        }

        foreach ($this->factories as $factory) {
            if ($app = $factory->createFrom($type)) {
                return $app;
            }
        }

        throw new LoaderException('Do not know how to create an app from ' . $this->type($type));
    }

    private function type($type) : string
    {
        $str = gettype($type);

        if ($str == 'object') {
            $str = 'object:' . get_class($type);
        }

        return $str;
    }
}
