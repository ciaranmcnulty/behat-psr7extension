<?php

/*
 * Example application used by the test automation
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

// simplest possible app
$app = new class
{
    function handle(ServerRequestInterface $request) : ResponseInterface
    {
        parse_str($request->getUri()->getQuery(), $params);

        $response = new Response();
        $response->getBody()->write('Hello ' . $params['name']);

        return $response;
    }
};

// callable wrapper for Behat
return function (ServerRequestInterface $request) use ($app) : ResponseInterface
{
    return $app->handle($request);
};
