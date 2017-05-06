<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\AppFile;

use Cjm\Behat\Psr7Extension\Psr7LoaderException;

final class FileNotFound extends Psr7LoaderException
{
    public function __construct(string $path)
    {
        parent::__construct('File not found at ' . $path);
    }
}
