<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\AppFile;

final class IncludedFileNotZendExpressiveApplication extends \InvalidArgumentException
{
    public static function fromFilename(string $filename) : self
    {
        return new self(sprintf(
            'Attempted to load app from %s but it did not return a Zend Expressive application',
            $filename
        ));
    }
}
