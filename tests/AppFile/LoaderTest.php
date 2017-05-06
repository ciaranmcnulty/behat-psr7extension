<?php

namespace Cjm\Behat\Psr7Extension\AppFile;

use Cjm\Behat\Psr7Extension\Psr7App;
use Cjm\Behat\Psr7Extension\Psr7AppFactory;
use PHPUnit\Framework\TestCase;

class LoaderTest extends TestCase
{
    const TMP_APP_FILE = '/tmp/app_file';

    private $loader;

    function setUp()
    {
        $this->loader = new Loader(
            self::TMP_APP_FILE,
            $this->createMock(Psr7AppFactory::class)
        );
    }

    function testItComplainsIfFileDoesNotExist()
    {
        $this->expectException(FileNotFound::class);

        $this->loader->load();
    }

    function testItThrowsExceptionIfFileDoesNotReturn()
    {
        $this->expectException(InvalidFile::class);

        file_put_contents(self::TMP_APP_FILE, '<?php ');

        $this->loader->load();
    }

    function testItThrowsExceptionIfNoFactoryCanMakeApp()
    {
        file_put_contents(self::TMP_APP_FILE, '<?php return "no idea";');

        $this->expectException(UnknownType::class);

        $this->loader->load();
    }

    function testItCreatesAnAppIfAFactoryCan()
    {
        $this->loader = new Loader(
            self::TMP_APP_FILE,
            $factory1 = $this->createMock(Psr7AppFactory::class),
            $factory2 = $this->createMock(Psr7AppFactory::class)
        );

        file_put_contents(self::TMP_APP_FILE, '<?php return "no idea";');
        $app = $this->createMock(Psr7App::class);

        $factory2->method('createFrom')->willReturn($app);

        $this->assertSame($app, $this->loader->load());
    }

    function tearDown()
    {
        @unlink(self::TMP_APP_FILE);
    }

}
