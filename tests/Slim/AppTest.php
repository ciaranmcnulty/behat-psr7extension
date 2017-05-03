<?php

namespace Cjm\Behat\Psr7Extension\Slim;

use Cjm\Behat\Psr7Extension\Slim\App;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

final class AppTest extends TestCase
{
    public function testItExecutesSlimAppToReturnResponse()
    {
        $slimApp = include __DIR__ . '/../../example-apps/slim-app.php';
        $app = new App($slimApp);

        $response = $app->handle(
            (new ServerRequest())
                ->withUri(new Uri('/'))
                ->withQueryParams(['name' => 'Ciaran'])
        );

        $this->assertSame('Hello Ciaran', (string) $response->getBody());
    }
}
