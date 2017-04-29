<?php

namespace Cjm\Behat\Psr7Extension;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Psr7App
{
    public function handle(RequestInterface $request) : ResponseInterface;
}
