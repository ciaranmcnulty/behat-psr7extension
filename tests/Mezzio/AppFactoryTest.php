<?php

namespace Cjm\Behat\Psr7Extension\Mezzio;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Mezzio\Application;

class AppFactoryTest extends \PHPUnit\Framework\TestCase
{
    private $factory;

    function setUp()
    {
        $this->factory = new AppFactory;
    }

    function testItDoesNotCreateAppFromNonMezzioApp()
    {
        $app = $this->factory->createFrom(new \StdClass);

        $this->assertSame(null, $app);
    }

    function testItCreatesAnAppFromAMezzioApp()
    {
        $app = $this->factory->createFrom($this->createMock(Application::class));

        $this->assertInstanceOf(App::class, $app);
    }
}
