<?php
namespace PhpDDD\PhpDDDBundle\DependencyInjection\Compiler;

use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 */
abstract class AbstractBusAwareCompilerPass extends AbstractCompilerPass
{

    /**
     * @var string
     */
    private $busServiceId;

    /**
     * @var string
     */
    private $interfaceToImplement;

    /**
     * @var string
     */
    private $methodToCall;

    /**
     * @param string $busServiceId
     * @param string $interfaceToImplement
     * @param string $methodToCall
     */
    public function __construct($busServiceId, $interfaceToImplement, $methodToCall)
    {
        $this->busServiceId         = $busServiceId;
        $this->interfaceToImplement = $interfaceToImplement;
        $this->methodToCall         = $methodToCall;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->busServiceId)) {
            return;
        }

        $bus = new Reference($this->busServiceId);

        foreach ($container->getDefinitions() as $definition) {
            $class = $this->resolveClassName($container, $definition->getClass());

            $refClass = new ReflectionClass($class);

            if (!$refClass->implementsInterface($this->interfaceToImplement)) {
                continue;
            }

            $definition->addMethodCall($this->methodToCall, array($bus));
        }
    }
}
