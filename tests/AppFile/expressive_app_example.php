<?php
declare(strict_types=1);

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\AppFactory;

$app = AppFactory::create();
$app->get(
    '/',
    new class implements MiddlewareInterface {
        public function process(ServerRequestInterface $request, DelegateInterface $delegate)
        {
            $response = new \Zend\Diactoros\Response();
            $response->getBody()->write('Hello ' . $request->getQueryParams()['name']);

            return $response;
        }
    },
    'index'
);
$app->pipeRoutingMiddleware();
$app->pipeDispatchMiddleware();
return $app;
