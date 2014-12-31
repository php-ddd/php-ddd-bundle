<?php
namespace PhpDDD\PhpDDDBundle;

use PhpDDD\Command\Bus\CommandBusInterface;

interface CommandBusAwareInterface
{
    /**
     * @param CommandBusInterface $commandBus
     *
     * @return void
     */
    public function setCommandBus(CommandBusInterface $commandBus);
}
