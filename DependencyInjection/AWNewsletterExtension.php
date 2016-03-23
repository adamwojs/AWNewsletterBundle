<?php

namespace AW\NewsletterBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AWNewsletterExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        if ('custom' !== $config['db_driver']) {
            $loader->load(sprintf('%s.yml', $config['db_driver']));
        }

        if ($config['confirmation']['enabled']) {
            $loader->load('confirmation_email.yml');
        }

        if ($config['welcome']['enabled']) {
            $loader->load('welcome_email.yml');
        }

        $container->setAlias('aw_newsletter.newsletter_manager', $config['service']['newsletter_manager']);
        $container->setParameter('aw_newsletter.subscriber_class', $config['subscriber_class']);
        $container->setParameter('aw_newsletter.form.name', $config['form']['name']);
        $container->setParameter('aw_newsletter.form.type', $config['form']['type']);
        $container->setParameter('aw_newsletter.form.validation_groups', $config['form']['validation_groups']);
        $container->setParameter('aw_newsletter.confirmation.enabled', $config['confirmation']['enabled']);
        $container->setParameter('aw_newsletter.confirmation.sender.name', $config['confirmation']['sender']['name']);
        $container->setParameter('aw_newsletter.confirmation.sender.address', $config['confirmation']['sender']['address']);
        $container->setParameter('aw_newsletter.welcome.enabled', $config['welcome']['enabled']);
        $container->setParameter('aw_newsletter.welcome.sender.name', $config['welcome']['sender']['name']);
        $container->setParameter('aw_newsletter.welcome.sender.address', $config['welcome']['sender']['address']);

        $loader->load('newsletter.yml');

    }
}
