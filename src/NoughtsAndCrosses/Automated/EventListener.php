<?php

namespace NoughtsAndCrosses\Automated;

use NoughtsAndCrosses\Core\Event\Event;

interface EventListener
{
    public function accept(Event $event);

    public function listen(Event $event);
}
