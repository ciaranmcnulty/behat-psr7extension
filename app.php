<?php

/*
 * Example application used by the test automation
 */

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

// simplest possible app
$app = new class
{
    function handle(RequestInterface $request) : ResponseInterface
    {
        parse_str($request->getUri()->getQuery(), $params);

        $response = new Response();
        $response->getBody()->write('Hello ' . $params['name']);

        return $response;
    }
};

// callable wrapper for Behat
return function (RequestInterface $request) use ($app) : ResponseInterface
{
    return $app->handle($request);
};
