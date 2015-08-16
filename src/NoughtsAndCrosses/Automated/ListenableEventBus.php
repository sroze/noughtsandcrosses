<?php

namespace NoughtsAndCrosses\Automated;

use NoughtsAndCrosses\Core\Event\Event;
use NoughtsAndCrosses\Core\Event\EventBus;
use NoughtsAndCrosses\Core\Event\EventStore;

class ListenableEventBus implements EventBus, EventStore
{
    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * @var EventListener[]
     */
    private $listeners;

    public function __construct(EventBus $eventBus, array $listeners = [])
    {
        $this->eventBus = $eventBus;
        $this->listeners = $listeners;
    }

    public function dispatch(Event $event)
    {
        $this->eventBus->dispatch($event);
        $this->dispatchToListeners($event);
    }

    public function dispatchAll(array $events)
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }

    private function dispatchToListeners(Event $event)
    {
        foreach ($this->listeners as $listener) {
            if ($listener->accept($event)) {
                $listener->listen($event);
            }
        }
    }

    public function registerListener(EventListener $listener)
    {
        $this->listeners[] = $listener;
    }

    public function registerListeners(array $listeners)
    {
        foreach ($listeners as $listener) {
            $this->registerListener($listener);
        }
    }

    public function findByAggregateId($identity)
    {
        if (!$this->eventBus instanceof EventStore) {
            throw new \RuntimeException('Not supported');
        }

        return $this->eventBus->findByAggregateId($identity);
    }
}
