<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\Mezzio;

use Cjm\Behat\Psr7Extension\Mezzio\App;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;

final class AppTest extends TestCase
{
    public function testItExecutesMezzioAppToReturnResponse()
    {
        $mezzioApp = include __DIR__ . '/../../example-apps/mezzio-app.php';
        $app = new App($mezzioApp);

        $response = $app->handle(
            (new ServerRequest())
                ->withUri(new Uri('/'))
                ->withQueryParams(['name' => 'Ciaran'])
        );

        $this->assertSame('Hello Ciaran', (string) $response->getBody());
    }
}
