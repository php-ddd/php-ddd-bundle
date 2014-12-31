<?php
namespace PhpDDD\PhpDDDBundle\DependencyInjection\Compiler;

class CommandHandlerLocatorCompilerPass extends AbstractLocatorCompilerPass
{
    public function __construct()
    {
        parent::__construct(
            'phpddd_command.handler_locator',
            'PhpDDD\Command\Handler\CommandHandlerInterface',
            'php_ddd.command_handler',
            'command'
        );
    }
}
