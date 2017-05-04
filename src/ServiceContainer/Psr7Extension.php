<?php
declare(strict_types=1);

namespace Cjm\Behat\Psr7Extension\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

final class Psr7Extension implements Extension
{
    /**
     * Configure the kernel that browserkit will talk to
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.yml');

        $container->setParameter('cjm.behat.psr7.app', $config['app']);
    }

    /**
     * Register tagged application factories
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('cjm.behat.psr7.loader');
        $taggedServices = $container->findTaggedServiceIds('cjm.behat.psr7.factory');

        foreach ($taggedServices as $id => $tags) {
            $definition->addArgument(new Reference($id));
        }
    }

    /**
     * Unique key per extension
     */
    public function getConfigKey()
    {
        return 'psr7';
    }

    /**
     * Adds the psr7 driver factory to minkextension before minkextension is configured
     */
    public function initialize(ExtensionManager $extensionManager)
    {

        if (null !== $minkExtension = $extensionManager->getExtension('mink')) {
            $minkExtension->registerDriverFactory(new Psr7DriverFactory());
        }
    }

    /**
     * Rules for parsing the options
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('app')->isRequired()->end()
            ->end()
        ->end();
    }
}
