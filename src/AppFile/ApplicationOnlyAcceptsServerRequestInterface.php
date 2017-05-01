<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\AppFile;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ApplicationOnlyAcceptsServerRequestInterface extends \InvalidArgumentException
{
    public static function fromRequest(RequestInterface $request) : self
    {
        return new self(sprintf(
            'Given PSR-7 request for %s was not an instance of %s, but the application requires one',
            $request->getUri()->__toString(),
            ServerRequestInterface::class
        ));
    }
}
