<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\AppFile;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

final class ApplicationOnlyAcceptsServerRequestInterfaceTest extends TestCase
{
    public function testMessageIsSetCorrectly()
    {
        $uriString = uniqid('uriString', true);
        /** @var UriInterface|\PHPUnit_Framework_MockObject_MockObject $uri */
        $uri = $this->createMock(UriInterface::class);
        $uri->expects(self::once())->method('__toString')->willReturn($uriString);
        /** @var RequestInterface|\PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->createMock(RequestInterface::class);
        $request->expects(self::once())->method('getUri')->willReturn($uri);

        $exception = ApplicationOnlyAcceptsServerRequestInterface::fromRequest($request);

        self::assertInstanceOf(ApplicationOnlyAcceptsServerRequestInterface::class, $exception);
        self::assertSame(
            sprintf(
                'Given PSR-7 request for %s was not an instance of %s, but the application requires one',
                $uriString,
                ServerRequestInterface::class
            ),
            $exception->getMessage()
        );
    }
}
