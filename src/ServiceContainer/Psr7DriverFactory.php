<?php

namespace Cjm\Behat\Psr7Extension\ServiceContainer;

use Behat\Mink\Driver\BrowserKitDriver;
use Behat\MinkExtension\ServiceContainer\Driver\DriverFactory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class Psr7DriverFactory implements DriverFactory
{
    /**
     * Gets the name of the driver being configured.
     *
     * This will be the key of the configuration for the driver.
     *
     * @return string
     */
    public function getDriverName()
    {
        return 'psr7';
    }

    /**
     * Defines whether a session using this driver is eligible as default javascript session
     *
     * @return boolean
     */
    public function supportsJavascript()
    {
        return false;
    }

    /**
     * Setups configuration for the driver factory.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function configure(ArrayNodeDefinition $builder)
    {
    }

    /**
     * Builds the service definition for the driver.
     *
     * @param array $config
     *
     * @return Definition
     */
    public function buildDriver(array $config)
    {
        return new Definition(
            BrowserKitDriver::class,
            [
                new Reference('cjm.behat.psr7.client'),
                '%mink.base_url%'
            ]
        );
    }
}
