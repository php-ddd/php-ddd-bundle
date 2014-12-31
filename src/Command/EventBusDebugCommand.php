<?php
namespace PhpDDD\PhpDDDBundle\Command;

use PhpDDD\Domain\Event\Bus\EventBusInterface;
use PhpDDD\Domain\Event\Listener\EventListenerCollection;
use Symfony\Component\Console\Helper\Table;

class EventBusDebugCommand extends AbstractBusDebugCommand
{
    protected function configure()
    {
        parent::configureCommand('php-ddd:event-bus:debug', 'phpddd_event.bus', array('Event', 'EventListeners'));
    }

    /**
     * @param Table                    $table
     * @param object|EventBusInterface $bus
     */
    protected function addRowsToTable(Table $table, $bus)
    {
        $list = $bus->getRegisteredEventListeners();
        foreach ($list as $eventListenerCollection) {
            $this->addEventListenerCollectionRows($table, $eventListenerCollection);
        }
    }

    /**
     * @param Table                   $table
     * @param EventListenerCollection $eventListenerCollection
     */
    private function addEventListenerCollectionRows(Table $table, EventListenerCollection $eventListenerCollection)
    {
        foreach ($eventListenerCollection as $eventListener) {
            $table->addRow(array($eventListenerCollection->getEventName(), get_class($eventListener)));
        }
    }
}
