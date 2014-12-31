<?php
namespace PhpDDD\PhpDDDBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class AbstractCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     * @param string           $class
     *
     * @return mixed
     */
    protected function resolveClassName(ContainerBuilder $container, $class)
    {
        // if the class starts with a %, then it's a parameter and we have to resolve it
        if (substr($class, 0, 1) === '%') {
            $class = substr($class, 1, strlen($class) - 2);

            return $container->getParameter($class);
        }

        return $class;
    }
}
