<?php
namespace PhpDDD\PhpDDDBundle\DependencyInjection\Compiler;

use InvalidArgumentException;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

abstract class AbstractLocatorCompilerPass extends AbstractCompilerPass
{

    /**
     * @var string
     */
    private $serviceName;

    /**
     * @var string
     */
    private $tagName;

    /**
     * @var string
     */
    private $interfaceToImplement;

    /**
     * @var string
     */
    private $tagAttribute;

    /**
     * @param string $serviceName
     * @param string $interfaceToImplement
     * @param string $tagName
     * @param string $tagAttribute
     */
    public function __construct($serviceName, $interfaceToImplement, $tagName, $tagAttribute)
    {
        $this->serviceName          = $serviceName;
        $this->tagName              = $tagName;
        $this->interfaceToImplement = $interfaceToImplement;
        $this->tagAttribute         = $tagAttribute;
    }

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @throws \InvalidArgumentException
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has($this->serviceName)) {
            // User did not activated the event plugin
            return;
        }

        foreach ($container->findTaggedServiceIds($this->tagName) as $id => $tagAttributes) {
            $this->manageService($container, $id, $tagAttributes);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param Definition       $definition
     * @param string           $id
     */
    private function assertClassImplementInterface(ContainerBuilder $container, Definition $definition, $id)
    {
        $class = $this->resolveClassName($container, $definition->getClass());

        $refClass = new ReflectionClass($class);
        if (!$refClass->implementsInterface($this->interfaceToImplement)) {
            throw new InvalidArgumentException(
                sprintf('Service "%s" must implement interface "%s".', $id, $this->interfaceToImplement)
            );
        }
    }

    /**
     * @param array $tagAttributes
     *
     * @return string|null
     */
    private function findEventAttribute(array $tagAttributes)
    {
        foreach ($tagAttributes as $attribute) {
            if (isset($attribute[$this->tagAttribute])) {
                return $attribute[$this->tagAttribute];
            }
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $id
     * @param array            $tagAttributes
     */
    private function manageService(ContainerBuilder $container, $id, array $tagAttributes)
    {
        $def = $container->getDefinition($id);

        $this->assertClassImplementInterface($container, $def, $id);

        $eventAttribute = $this->findEventAttribute($tagAttributes);

        if (null === $eventAttribute) {
            throw new InvalidArgumentException(
                sprintf(
                    'You must specify the event associated to the command handler by adding a "%s" attribute in the tag of the service "%s".',
                    $this->tagAttribute,
                    $id
                )
            );
        }

        $definition = $container->findDefinition($this->serviceName);
        $definition->addMethodCall('register', array($eventAttribute, new Reference($id)));
    }
}
