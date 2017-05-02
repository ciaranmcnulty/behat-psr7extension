<?php

namespace Cjm\Behat\Psr7Extension;

use Psr\Http\Message\RequestInterface as Psr7Request;
use Psr\Http\Message\ResponseInterface as Psr7Response;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

/**
 * Converts between Symfony and Psr-7 representations
 */
interface SymfonyToPsr7Converter
{
    public function convertRequest(HttpFoundationRequest $request) : Psr7Request;

    public function convertResponse(Psr7Response $response) : HttpFoundationResponse;
}
