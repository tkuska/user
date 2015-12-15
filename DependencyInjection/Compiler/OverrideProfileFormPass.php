<?php

namespace Tkuska\UserBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Description of OverrideProfileFormPass.
 *
 * @author Tomasz Kuśka <tomasz.kuska@gmail.com>
 */
class OverrideProfileFormPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('fos_user.profile.form.type');
        $definition->setClass('Tkuska\UserBundle\Form\Type\ProfileFormType');
    }
}
