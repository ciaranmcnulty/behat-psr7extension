<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$app = new \Slim\App;

$app->get(
    '/',
    function (ServerRequestInterface $request, ResponseInterface $response) {
        $name = $request->getQueryParams()['name'];
        $response->getBody()->write("Hello $name");

        return $response;
    }
);

return $app;
