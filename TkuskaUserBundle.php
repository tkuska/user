<?php

namespace Tkuska\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tkuska\UserBundle\DependencyInjection\Compiler\OverrideProfileFormPass;

class TkuskaUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new OverrideProfileFormPass());
    }
}
