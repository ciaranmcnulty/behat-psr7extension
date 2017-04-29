<?php

namespace Cjm\Behat\Psr7Extension\PsrHttpMessageBridge;

use Cjm\Behat\Psr7Extension\SymfonyToPsr7Converter as ConverterInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Psr\Http\Message\RequestInterface as Psr7Request;
use Zend\Diactoros\Response as Psr7Response;

class SymfonyToPsr7ConverterTest extends \PHPUnit\Framework\TestCase
{
    private $converter;

    function setUp()
    {
        $this->converter = new SymfonyToPsr7Converter(
            new DiactorosFactory(),
            new HttpFoundationFactory()
        );
    }

    function testItIsASymfonyToPsr7Converter()
    {
        $this->assertInstanceOf(ConverterInterface::class, $this->converter);
    }

    function testItConvertsTheSymfonyRequest()
    {
        $request = SymfonyRequest::create('http://localhost');

        $convertedRequest = $this->converter->convertRequest($request);

        $this->assertInstanceOf(Psr7Request::class, $convertedRequest);
    }

    function testItConvertsThePsr7Response()
    {
        $response = new Psr7Response();

        $convertedResponse = $this->converter->convertResponse($response);

        $this->assertInstanceOf(SymfonyResponse::class, $convertedResponse);
    }
}
