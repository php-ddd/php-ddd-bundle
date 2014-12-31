<?php
namespace PhpDDD\PhpDDDBundle;

use PhpDDD\Domain\Event\Bus\EventBusInterface;

interface EventBusAwareInterface
{
    /**
     * @param EventBusInterface $eventBus
     *
     * @return void
     */
    public function setEventBus(EventBusInterface $eventBus);
}
