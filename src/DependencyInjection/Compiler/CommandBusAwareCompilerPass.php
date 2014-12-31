<?php
namespace PhpDDD\PhpDDDBundle\DependencyInjection\Compiler;

/**
 */
class CommandBusAwareCompilerPass extends AbstractBusAwareCompilerPass
{
    /**
     */
    public function __construct()
    {
        parent::__construct('phpddd_command.bus', 'PhpDDD\PhpDDDBundle\CommandBusAwareInterface', 'setCommandBus');
    }
}
