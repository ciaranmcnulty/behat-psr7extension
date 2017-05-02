<?php

namespace Cjm\Behat\Psr7Extension\Slim;

use Slim\App as Application;

class AppFactoryTest extends \PHPUnit\Framework\TestCase
{
    private $factory;

    function setUp()
    {
        $this->factory = new AppFactory;
    }

    function testItDoesNotCreateAppFromNonSlimApp()
    {
        $app = $this->factory->createFrom(new \StdClass);

        $this->assertSame(null, $app);
    }

    function testItCreatesAnAppFromASlimApp()
    {
        $app = $this->factory->createFrom($this->createMock(Application::class));

        $this->assertInstanceOf(App::class, $app);
    }
}
