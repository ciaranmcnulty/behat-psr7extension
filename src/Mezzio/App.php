<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\Mezzio;

use Cjm\Behat\Psr7Extension\Psr7App;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Mezzio\Application;

final class App implements Psr7App
{
    private $mezzioApp;

    public function __construct(Application $mezzioApp)
    {
        $this->mezzioApp = $mezzioApp;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->mezzioApp->handle(
            $request
        );
    }
}
