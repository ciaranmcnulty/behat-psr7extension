<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\ZendExpressive;

use Cjm\Behat\Psr7Extension\Psr7App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Application;

final class App implements Psr7App
{
    private $expressiveApp;

    public function __construct(Application $expressiveApp)
    {
        $this->expressiveApp = $expressiveApp;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->expressiveApp->handle($request);
    }
}
