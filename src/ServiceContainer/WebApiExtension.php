<?php

/*
 * This file is part of the Behat WebApiExtension.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\WebApiExtension\ServiceContainer;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Web API extension for Behat.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class WebApiExtension implements ExtensionInterface
{
    const CLIENT_ID = 'web_api.client';
    const DIFFER_ID = 'web_api.differ';

    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'web_api';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('base_url')
                    ->defaultValue('http://localhost')
                ->end()

                ->scalarNode('differ')
                    ->defaultValue('coduo')
                ->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $this->loadClient($container, $config);
        $this->loadDiffers($container, $config);
        $this->loadContextInitializer($container, $config);
    }

    private function loadClient(ContainerBuilder $container, $config)
    {
        $definition = new Definition('GuzzleHttp\Client', array($config));
        $container->setDefinition(self::CLIENT_ID, $definition);
    }

    private function loadDiffers(ContainerBuilder $container, $config)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/config'));
        $loader->load('differs.xml');

        $container->setAlias('web_api.differ', 'web_api.differ.'.$config['differ']);
    }

    private function loadContextInitializer(ContainerBuilder $container, $config)
    {
        $definition = new Definition('Behat\WebApiExtension\Context\Initializer\ApiClientAwareInitializer', array(
          new Reference(self::CLIENT_ID),
          $config
        ));
        $definition->addTag(ContextExtension::INITIALIZER_TAG);
        $container->setDefinition('web_api.context_initializer', $definition);

        $definition = new Definition('Behat\WebApiExtension\Context\Initializer\DifferAwareInitializer', array(
          new Reference(self::DIFFER_ID),
          $config
        ));
        $definition->addTag(ContextExtension::INITIALIZER_TAG);
        $container->setDefinition('web_api.differ_context_initializer', $definition);
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
    }
}
