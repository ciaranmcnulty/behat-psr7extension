<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\Slim;

use Cjm\Behat\Psr7Extension\Psr7App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App as Application;
use Slim\Http\Response;

final class App implements Psr7App
{
    private $slimApp;

    public function __construct(Application $slimApp)
    {
        $this->slimApp = $slimApp;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return ($this->slimApp)(
            $request,
            new Response()
        );
    }

	public function getNativeApp() : Application
	{
		return $this->expressiveApp;
	}
}
