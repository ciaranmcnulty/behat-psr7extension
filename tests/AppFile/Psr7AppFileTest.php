<?php

namespace Cjm\Behat\Psr7Extension\AppFile;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class Psr7AppFileTest extends TestCase
{
    const TMP_APP_FILE = '/tmp/app_file';

    function testItComplainsIfFileDoesNotExist()
    {
        $this->expectException(Psr7AppFileException::class);

        new Psr7AppFile(self::TMP_APP_FILE);
    }

    function testItCannotHandleRequestIfFileDoesNotReturnCallable()
    {
        file_put_contents(self::TMP_APP_FILE, '<?php return 1;');
        $app = new Psr7AppFile(self::TMP_APP_FILE);

        $this->expectException(Psr7AppFileException::class);

        $app->handle($this->createMock(RequestInterface::class));
    }

    function testItExecutesCallableToReturnResponse()
    {
        copy(__DIR__ . '/../../app.php', self::TMP_APP_FILE);
        $app = new Psr7AppFile(self::TMP_APP_FILE);

        $response = $app->handle($this->createMock(RequestInterface::class));

        $this->assertSame('Hello Ciaran', (string) $response->getBody());
    }

    function tearDown()
    {
        @unlink(self::TMP_APP_FILE);
    }
}
