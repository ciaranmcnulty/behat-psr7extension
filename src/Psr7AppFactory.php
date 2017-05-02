<?php

namespace Cjm\Behat\Psr7Extension;

/**
 * Can create a Psr7App from a particular type
 */
interface Psr7AppFactory
{
    /**
     * @return Psr7App|null Returns null if app can't be created
     */
    function createFrom($mixed);
}
