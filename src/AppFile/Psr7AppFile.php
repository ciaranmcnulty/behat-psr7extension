<?php

namespace Cjm\Behat\Psr7Extension\AppFile;

use Cjm\Behat\Psr7Extension\Psr7App;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class Psr7AppFile implements Psr7App
{
    private $path;

    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new Psr7AppFileException('No file found at ' . $path);
        }

        $this->path = $path;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        $callable = include $this->path;

        if (!is_callable($callable)) {
            throw new Psr7AppFileException('File at ' . $this->path . ' must return a callable');
        }

        return $callable($request);
    }
}
