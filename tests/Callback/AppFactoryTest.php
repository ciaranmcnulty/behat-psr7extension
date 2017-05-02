<?php

namespace Cjm\Behat\Psr7Extension\Callback;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AppFactoryTest extends \PHPUnit\Framework\TestCase
{
    private $factory;

    function setUp()
    {
        $this->factory = new AppFactory;
    }

    function testItDoesNotCreateAppFromNonCallable()
    {
        $app = $this->factory->createFrom(new \StdClass);

        $this->assertSame(null, $app);
    }

    function testItCreatesAnAppFromACallable()
    {
        $app = $this->factory->createFrom(function (ServerRequestInterface $req) : ResponseInterface {});

        $this->assertInstanceOf(App::class, $app);
    }
}
