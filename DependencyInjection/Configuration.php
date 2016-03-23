<?php

namespace AW\NewsletterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('aw_newsletter');

        $supportedDrivers = ['orm', 'custom'];

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('subscriber_class')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('form')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('type')->defaultValue('aw_newsletter')->end()
                        ->scalarNode('name')->defaultValue('aw_newsletter_form')->end()
                        ->arrayNode('validation_groups')
                            ->prototype('scalar')->end()
                            ->defaultValue(['Default'])
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('confirmation')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('enabled')->defaultValue(true)->end()
                        ->arrayNode('sender')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('address')->defaultValue('no-reply@newsletter.com')->end()
                                ->scalarNode('name')->defaultValue('Newsletter')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('welcome')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('enabled')->defaultValue(true)->end()
                        ->arrayNode('sender')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('address')->defaultValue('no-reply@newsletter.com')->end()
                                ->scalarNode('name')->defaultValue('Newsletter')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('newsletter_manager')->defaultValue('aw_newsletter.newsletter_manager.default')->end()
                        ->arrayNode('sender')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('address')->end()
                                ->scalarNode('name')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->validate()
                ->ifTrue(function($v) {
                    return 'custom' === $v['db_driver'] && 'aw_newsletter.aw_newsletter_manager.default' === $v['service']['newsletter_manager'];
                })
                ->thenInvalid('You need to specify your own newsletter manager service when using the "custom" driver.')
            ->end()
        ;

        return $treeBuilder;
    }
}
