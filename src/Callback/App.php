<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\Callback;

use Cjm\Behat\Psr7Extension\Psr7App;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * App that delegates to a callback
 */
class App implements Psr7App
{
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function handle(Request $request): Response
    {
        return ($this->callback)($request);
    }
}
