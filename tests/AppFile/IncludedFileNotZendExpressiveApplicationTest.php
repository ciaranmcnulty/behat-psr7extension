<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\AppFile;

use PHPUnit\Framework\TestCase;

final class IncludedFileNotZendExpressiveApplicationTest extends TestCase
{
    public function testMessageIsSetCorrectly()
    {
        $filename = uniqid('filename', true);
        $exception = IncludedFileNotZendExpressiveApplication::fromFilename($filename);

        self::assertInstanceOf(IncludedFileNotZendExpressiveApplication::class, $exception);
        self::assertSame(
            sprintf('Attempted to load app from %s but it did not return a Zend Expressive application', $filename),
            $exception->getMessage()
        );
    }
}
