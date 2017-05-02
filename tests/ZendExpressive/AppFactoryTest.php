<?php

namespace Cjm\Behat\Psr7Extension\ZendExpressive;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Application;

class AppFactoryTest extends \PHPUnit\Framework\TestCase
{
    private $factory;

    function setUp()
    {
        $this->factory = new AppFactory;
    }

    function testItDoesNotCreateAppFromNonZendExpressiveApp()
    {
        $app = $this->factory->createFrom(new \StdClass);

        $this->assertSame(null, $app);
    }

    function testItCreatesAnAppFromAZendExpressiveApp()
    {
        $app = $this->factory->createFrom($this->createMock(Application::class));

        $this->assertInstanceOf(App::class, $app);
    }
}
