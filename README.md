PhpDDDBundle
============

PhpDDDBundle provides some tools to integrate php-ddd/domain-event and php-ddd/command inside your Symfony application.

Features
--------

* Services for SequentialCommandBus and CommandHandlerLocator
* Services for EventBus and EventListenerLocator
* A service tag to link Command with CommandHandler easily
* A service tag to link Event with EventListener easily
* A `php-ddd:command-bus:debug` Symfony command to list every Command/CommandHandler for a given CommandBus
* A `php-ddd:event-bus:debug` Symfony command to list every Event/EventListener attached to a given EventBus

Usage
-----

### Link a CommandHandler to a Command using tags

The easiest way to link a CommandHandler to a Command is by using service tag `php_ddd.command_handler` on the CommandHandler:

```yml
# services.yml
services:
    my.command_handler.foo:
        class: My/CommandHandler/FooCommandHandler
        tags:
            - { name: php_ddd.command_handler, command: My/Command/Foo }
```

The CommandHandler will be automatically registered in the `phpddd_command.handler_locator` service which correspond to a CommandHandlerLocator.  
This CommandHandlerLocator is then passed to the `phpddd_command.bus` service which correspond to a SequentialCommandBus by default.


### Add an EventListener listening to an Event using tags

It works the same way as for CommandHandler and Command:

```yml
# services.yml
services:
    my.listener.bar:
        class: My/EventListener/BarEventListener
        tags:
            - { name: php_ddd.event_listener, event: Other/Event/Bar }
```

The EventListener will be automatically registered in the `phpddd_event.listener_locator` service which correspond to an EventListenerLocator.  
This EventListener is then passed to the `phpddd_event.bus` service which correspond to an EventBus by default.

