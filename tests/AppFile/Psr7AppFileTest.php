<?php

namespace Cjm\Behat\Psr7Extension\AppFile;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class Psr7AppFileTest extends TestCase
{
    const TMP_APP_FILE = '/tmp/app_file';

    function testItComplainsIfFileDoesNotExist()
    {
        $this->expectException(Psr7AppFileException::class);

        new Psr7AppFile(self::TMP_APP_FILE);
    }

    function testItCannotHandleRequestIfFileDoesNotReturnCallable()
    {
        file_put_contents(self::TMP_APP_FILE, '<?php return 1;');
        $app = new Psr7AppFile(self::TMP_APP_FILE);

        $this->expectException(Psr7AppFileException::class);

        $app->handle($this->createMock(RequestInterface::class));
    }

    function testItExecutesCallableToReturnResponse()
    {
        copy(__DIR__ . '/../../app.php', self::TMP_APP_FILE);
        $app = new Psr7AppFile(self::TMP_APP_FILE);

        $request = $this->createMock(RequestInterface::class);

        $uri = $this->createMock(UriInterface::class);
        $request->method('getUri')->willReturn($uri);
        $uri->method('getQuery')->willReturn('name=Ciaran');

        $response = $app->handle($request);

        $this->assertSame('Hello Ciaran', (string) $response->getBody());
    }

    function tearDown()
    {
        @unlink(self::TMP_APP_FILE);
    }
}
