<?php

namespace Cjm\Behat\Psr7Extension;

class CachingLoader implements Psr7AppLoader
{
    private $loader;
    private $app;

    public function __construct(Psr7AppLoader $loader)
    {
        $this->loader = $loader;
    }

    public function load(): Psr7App
    {
        return $this->app ?: ($this->app = $this->loader->load());
    }
}
