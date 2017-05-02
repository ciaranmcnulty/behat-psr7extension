<?php

namespace Cjm\Behat\Psr7Extension;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface Psr7App
{
    public function handle(Request $request) : Response;
}
