<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\AppFile;

use Cjm\Behat\Psr7Extension\Psr7App;
use Cjm\Behat\Psr7Extension\Psr7AppFactory;
use Cjm\Behat\Psr7Extension\Psr7AppLoader;

/**
 * Loads an app by reading a file and finding an appropriate factory
 */
class Loader implements Psr7AppLoader
{
    private $path;
    private $factories;

    public function __construct(string $path, Psr7AppFactory ...$factories)
    {
        $this->factories = $factories;
        $this->path = $path;
    }

    public function load(): Psr7App
    {
        $type = $this->loadFromFile($this->path);

        foreach ($this->factories as $factory) {
            if ($app = $factory->createFrom($type)) {
                return $app;
            }
        }

        throw new UnknownType($type);
    }

    private function loadFromFile(string $path)
    {
        if (!file_exists($path)) {
            throw new FileNotFound($path);
        }

        $type = include $path;

        if (1 === $type) {
            throw new InvalidFile($path);
        }

        return $type;
    }
}
