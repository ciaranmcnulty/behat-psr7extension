<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\ZendExpressive;

use Cjm\Behat\Psr7Extension\ZendExpressive\App;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

final class AppTest extends TestCase
{
    public function testItExecutesExpressiveAppToReturnResponse()
    {
        $expressiveApp = include __DIR__ . '/../../example-apps/zend-expressive/zend-expressive-app.php';
        $app = new App($expressiveApp);

        $response = $app->handle(
            (new ServerRequest())
                ->withUri(new Uri('/'))
                ->withQueryParams(['name' => 'Ciaran'])
        );

        $this->assertSame('Hello Ciaran', (string) $response->getBody());
    }
}
