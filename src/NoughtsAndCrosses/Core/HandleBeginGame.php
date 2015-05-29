<?php

namespace NoughtsAndCrosses\Core;

use NoughtsAndCrosses\Core\Command\Command;
use NoughtsAndCrosses\Core\Command\CommandHandler;
use NoughtsAndCrosses\Core\Event\EventBus;

class HandleBeginGame implements CommandHandler
{
    private $eventBus;

    public function __construct(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function handle(Command $command)
    {
        $game = Game::begin($command->id());

        $this->eventBus->dispatchAll($game->getNewEvents());
    }

    public function supports(Command $command)
    {
        return $command instanceof BeginGame;
    }
}
