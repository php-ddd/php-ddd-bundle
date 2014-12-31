<?php
namespace PhpDDD\PhpDDDBundle;

use PhpDDD\PhpDDDBundle\DependencyInjection\Compiler\CommandBusAwareCompilerPass;
use PhpDDD\PhpDDDBundle\DependencyInjection\Compiler\CommandHandlerLocatorCompilerPass;
use PhpDDD\PhpDDDBundle\DependencyInjection\Compiler\EventBusAwareCompilerPass;
use PhpDDD\PhpDDDBundle\DependencyInjection\Compiler\EventListenerLocatorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PhpDDDBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CommandBusAwareCompilerPass());
        $container->addCompilerPass(new CommandHandlerLocatorCompilerPass());

        $container->addCompilerPass(new EventBusAwareCompilerPass());
        $container->addCompilerPass(new EventListenerLocatorCompilerPass());
    }
}
