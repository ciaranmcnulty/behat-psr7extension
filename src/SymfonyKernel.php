<?php

namespace Cjm\Behat\Psr7Extension;

use Cjm\Behat\Psr7Extension\Psr7App;
use Cjm\Behat\Psr7Extension\SymfonyToPsr7Converter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Adapts an arbitrary PSR-7 callable into a Symfony HttpKernel
 */
final class SymfonyKernel implements HttpKernelInterface
{
    private $app;
    private $converter;

    public function __construct(Psr7App $app, SymfonyToPsr7Converter $converter)
    {
        $this->app = $app;
        $this->converter = $converter;
    }

    /**
     * @return Response A Response instance
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        return $this->converter->convertResponse(
            $this->app->handle(
                $this->converter->convertRequest($request)
            )
        );
    }
}
