<?php
namespace PhpDDD\PhpDDDBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

abstract class AbstractBusDebugCommand extends ContainerAwareCommand
{

    /**
     * @var string[]
     */
    private $tableLabels;

    /**
     * @param string   $commandName
     * @param string   $defaultName
     * @param string[] $tableHeaderLabel
     */
    protected function configureCommand($commandName, $defaultName, array $tableHeaderLabel)
    {
        $this
            ->setName($commandName)
            ->addArgument('name', InputArgument::OPTIONAL, 'Name of the bus service', $defaultName)
            ->setDescription('List every listeners associated to the bus');
        $this->tableLabels = $tableHeaderLabel;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $busName = $input->getArgument('name');

        $table = new Table($output);
        $table->setHeaders($this->tableLabels);

        $this->addRowsToTable($table, $this->getBus($busName));

        $table->render();
    }

    /**
     * @param string $busName
     *
     * @return object
     */
    protected function getBus($busName)
    {
        if (!$this->getContainer()->has($busName)) {
            throw new ServiceNotFoundException($busName);
        }

        return $this->getContainer()->get($busName);
    }

    /**
     * @param Table  $table
     * @param object $bus
     */
    abstract protected function addRowsToTable(Table $table, $bus);
}
