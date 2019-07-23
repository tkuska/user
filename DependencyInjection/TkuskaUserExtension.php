<?php

namespace Tkuska\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use FOS\UserBundle\DependencyInjection\FOSUserExtension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TkuskaUserExtension extends FOSUserExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('tkuska_user.password_expiration_time', $config['password_expiration_time']);
        $container->setParameter('tkuska_user.creation.force_change_password', $config['creation']['force_change_password']);
        $container->setParameter('tkuska_user.creation.form.template', $config['creation']['form']['template']);
        $container->setParameter('tkuska_user.edition.form.template', $config['edition']['form']['template']);
        $container->setParameter('tkuska_user.mailer', $config['mailer']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $this->loadCreation($config['creation'], $container, $loader, $config['from_email']);
        $this->loadEdition($config['edition'], $container, $loader);
        $loader->load('services.xml');
    }

    private function loadCreation(array $config, ContainerBuilder $container, XmlFileLoader $loader, array $fromEmail)
    {
        $loader->load('creation.xml');

        if (isset($config['confirmation']['from_email'])) {
            // overwrite the global one
            $fromEmail = $config['confirmation']['from_email'];
            unset($config['confirmation']['from_email']);
        }
        $container->setParameter('tkuska_user.creation.confirmation.from_email', array($fromEmail['address'] => $fromEmail['sender_name']));

        $this->remapParametersNamespaces($config, $container, array(
            'confirmation' => 'tkuska_user.creation.confirmation.%s',
            'form' => 'tkuska_user.creation.form.%s',
        ));
    }

    private function loadEdition(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('edition.xml');

        $this->remapParametersNamespaces($config, $container, array(
            'form' => 'tkuska_user.edition.form.%s',
        ));
    }
}
