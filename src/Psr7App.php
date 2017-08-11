<?php

namespace Cjm\Behat\Psr7Extension;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Testable PSR-7 app
 */
interface Psr7App
{
    public function handle(Request $request) : Response;

    public function getNativeApp();
}
