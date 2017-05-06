<?php

namespace Cjm\Behat\Psr7Extension;

use PHPUnit\Framework\TestCase;

class CachingLoaderTest extends TestCase
{
    private $innerLoader;
    private $innerApp;
    private $loader;

    public function setUp()
    {
        $this->innerLoader = $this->createMock(Psr7AppLoader::class);
        $this->innerApp = $this->createMock(Psr7App::class);

        $this->innerLoader->method('load')->willReturn($this->innerApp);

        $this->loader = new CachingLoader($this->innerLoader);
    }

    public function testItLoadsTheApp()
    {
        $app = $this->loader->load();

        $this->assertSame($this->innerApp, $app);
    }

    public function testItOnlyLoadsTheAppOnce()
    {
        $this->innerLoader
             ->expects($this->once())
             ->method('load');

        $this->loader->load();
        $app = $this->loader->load();

        $this->assertSame($this->innerApp, $app);
    }
}
