<?php
namespace PhpDDD\PhpDDDBundle\DependencyInjection\Compiler;

/**
 */
class EventBusAwareCompilerPass extends AbstractBusAwareCompilerPass
{
    /**
     */
    public function __construct()
    {
        parent::__construct('phpddd_event.bus', 'PhpDDD\PhpDDDBundle\EventBusAwareInterface', 'setEventBus');
    }
}
