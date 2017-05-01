<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\AppFile;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

final class ZendExpressiveApplicationAdapterTest extends TestCase
{
    const TMP_APP_FILE = '/tmp/zend_expressive_app_file';

    public function testItComplainsIfFileDoesNotExist()
    {
        $this->expectException(Psr7AppFileException::class);

        new ZendExpressiveApplicationAdapter(self::TMP_APP_FILE);
    }

    public function testItComplainsIfNotGivenServerRequest()
    {
        file_put_contents(self::TMP_APP_FILE, '<?php return 1;');
        $app = new ZendExpressiveApplicationAdapter(self::TMP_APP_FILE);

        /** @var UriInterface|\PHPUnit_Framework_MockObject_MockObject $uri */
        $uri = $this->createMock(UriInterface::class);
        $uri->expects(self::once())->method('__toString')->willReturn(uniqid('request', true));
        /** @var RequestInterface|\PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->createMock(RequestInterface::class);
        $request->expects(self::once())->method('getUri')->willReturn($uri);

        $this->expectException(ApplicationOnlyAcceptsServerRequestInterface::class);
        $app->handle($request);
    }

    public function testItCannotHandleRequestIfFileDoesNotReturnCallable()
    {
        file_put_contents(self::TMP_APP_FILE, '<?php return 1;');
        $app = new ZendExpressiveApplicationAdapter(self::TMP_APP_FILE);

        $this->expectException(IncludedFileNotZendExpressiveApplication::class);

        /** @var ServerRequestInterface|\PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->createMock(ServerRequestInterface::class);

        $app->handle($request);
    }

    public function testItExecutesCallableToReturnResponse()
    {
        copy(__DIR__ . '/expressive_app_example.php', self::TMP_APP_FILE);
        $app = new ZendExpressiveApplicationAdapter(self::TMP_APP_FILE);

        $name = uniqid('Ciaran', true);

        $response = $app->handle(
            (new ServerRequest())
                ->withUri(new Uri('/'))
                ->withQueryParams(['name' => $name])
        );

        self::assertSame('Hello ' . $name, (string) $response->getBody());
    }

    public function tearDown()
    {
        @unlink(self::TMP_APP_FILE);
    }
}
