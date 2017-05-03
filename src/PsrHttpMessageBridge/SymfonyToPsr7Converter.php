<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\PsrHttpMessageBridge;

use Psr\Http\Message\RequestInterface as Psr7Request;
use Psr\Http\Message\ResponseInterface as Psr7Response;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

/**
 * Converts between formats using psr-http-message-bridge
 */
class SymfonyToPsr7Converter implements \Cjm\Behat\Psr7Extension\SymfonyToPsr7Converter
{
    private $psr7Factory;
    private $symfonyFactory;

    public function __construct(
        HttpMessageFactoryInterface $psr7Factory,
        HttpFoundationFactoryInterface $symfonyFactory
    )
    {
        $this->psr7Factory = $psr7Factory;
        $this->symfonyFactory = $symfonyFactory;
    }

    public function convertRequest(HttpFoundationRequest $request): Psr7Request
    {
        return $this->psr7Factory->createRequest($request);
    }

    public function convertResponse(Psr7Response $response): HttpFoundationResponse
    {
        return $this->symfonyFactory->createResponse($response);
    }
}
