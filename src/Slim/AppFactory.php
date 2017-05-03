<?php

namespace Cjm\Behat\Psr7Extension\Slim;

use Cjm\Behat\Psr7Extension\Psr7App;
use Cjm\Behat\Psr7Extension\Psr7AppFactory;
use Slim\App as Application;

class AppFactory implements Psr7AppFactory
{
    /**
     * @return Psr7App|null Returns null if app can't be created
     */
    function createFrom($type)
    {
        if ($type instanceof Application) {
            return new App($type);
        }

        return null;
    }
}
