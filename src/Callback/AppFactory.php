<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\Callback;

use Cjm\Behat\Psr7Extension\Psr7App;
use Cjm\Behat\Psr7Extension\Psr7AppFactory;

/**
 * Converts a callable into an app
 */
class AppFactory implements Psr7AppFactory
{
    /**
     * @return Psr7App|null Returns null if app can't be created
     */
    function createFrom($mixed)
    {
        if (is_callable($mixed)) {
            return new App($mixed);
        }

        return null;
    }
}
