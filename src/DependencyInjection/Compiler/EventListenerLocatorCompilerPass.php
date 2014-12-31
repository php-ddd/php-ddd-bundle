<?php
namespace PhpDDD\PhpDDDBundle\DependencyInjection\Compiler;

class EventListenerLocatorCompilerPass extends AbstractLocatorCompilerPass
{
    public function __construct()
    {
        parent::__construct(
            'phpddd_event.listener_locator',
            'PhpDDD\Domain\Event\Listener\EventListenerInterface',
            'php_ddd.event_listener',
            'event'
        );
    }
}
