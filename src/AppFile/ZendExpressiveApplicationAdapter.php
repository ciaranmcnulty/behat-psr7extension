<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\AppFile;

use Cjm\Behat\Psr7Extension\Psr7App;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Application;

final class ZendExpressiveApplicationAdapter implements Psr7App
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new Psr7AppFileException('No file found at ' . $path);
        }

        $this->path = $path;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        if (! $request instanceof ServerRequestInterface) {
            throw ApplicationOnlyAcceptsServerRequestInterface::fromRequest($request);
        }

        $app = include $this->path;

        if (! $app instanceof Application) {
            throw IncludedFileNotZendExpressiveApplication::fromFilename($this->path);
        }

        return $app->process($request, $app->getDefaultDelegate());
    }
}
