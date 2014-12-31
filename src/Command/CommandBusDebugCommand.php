<?php
namespace PhpDDD\PhpDDDBundle\Command;

use PhpDDD\Command\Bus\CommandBusInterface;
use Symfony\Component\Console\Helper\Table;

class CommandBusDebugCommand extends AbstractBusDebugCommand
{
    protected function configure()
    {
        parent::configureCommand('php-ddd:command-bus:debug', 'phpddd_command.bus', array('Command', 'CommandHandler'));
    }

    /**
     * @param Table               $table
     * @param CommandBusInterface $bus
     */
    protected function addRowsToTable(Table $table, $bus)
    {
        $handlers = $bus->getRegisteredCommandHandlers();
        foreach ($handlers as $commandName => $commandHandler) {
            $table->addRow(array($commandName, get_class($commandHandler)));
        }
    }
}
