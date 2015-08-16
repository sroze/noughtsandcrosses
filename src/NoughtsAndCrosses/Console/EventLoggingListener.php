<?php

namespace NoughtsAndCrosses\Console;

use NoughtsAndCrosses\Automated\EventListener;
use NoughtsAndCrosses\Core\Event\Event;

class EventLoggingListener implements EventListener
{
    public function accept(Event $event)
    {
        return true;
    }

    public function listen(Event $event)
    {
        echo get_class($event)."\n";
        if (method_exists($event, '__toString')) {
            echo $event->__toString()."\n";
        }

        echo "\n";
    }
}
