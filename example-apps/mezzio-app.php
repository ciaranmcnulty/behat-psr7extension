<?php
declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ServiceManager\ServiceManager;
use Mezzio\Router\Middleware\RouteMiddleware;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

$config = (new ConfigAggregator([
    \Mezzio\ConfigProvider::class,
    \Mezzio\Router\ConfigProvider::class,
    \Mezzio\Router\FastRouteRouter\ConfigProvider::class,
]))->getMergedConfig();

$dependencies                       = $config['dependencies'];
$dependencies['services']['config'] = $config;

$container = new ServiceManager($dependencies);

/** @var \Mezzio\Application $app **/
$app = $container->get(\Mezzio\Application::class);

$app->get(
    '/',
    new class implements MiddlewareInterface {
        public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
        {
            $response = new \Laminas\Diactoros\Response();
            $response->getBody()->write('Hello ' . $request->getQueryParams()['name']);

            return $response;
        }
    },
    'index'
);

$app->pipe(RouteMiddleware::class);
$app->pipe(DispatchMiddleware::class);

return $app;
