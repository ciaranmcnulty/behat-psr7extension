<?php

namespace Cjm\Behat\Psr7Extension\Callback;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AppTest extends TestCase
{
    function testItExecutesTheCallback()
    {
        $expectedResponse = $this->createMock(ResponseInterface::class);

        $callback = function () use ($expectedResponse) {
            return $expectedResponse;
        };

        $app = new App($callback);

        $response = $app->handle($this->createMock(ServerRequestInterface::class));

        $this->assertSame($expectedResponse, $response);
    }
}
