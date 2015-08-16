<?php

namespace NoughtsAndCrosses\Automated;

use NoughtsAndCrosses\Automated\Listener\GameBeganListener;
use NoughtsAndCrosses\Automated\Listener\MoveTakenListener;
use NoughtsAndCrosses\Core\BeginGame;
use NoughtsAndCrosses\Core\GameId;
use NoughtsAndCrosses\Core\HandleBeginGame;
use NoughtsAndCrosses\Core\HandleTakeMove;
use NoughtsAndCrosses\Infrastructure\InMemory\CommandBus;
use NoughtsAndCrosses\Infrastructure\InMemory\EventBus;
use NoughtsAndCrosses\Infrastructure\InMemory\Games;

class GameManager
{
    /**
     * @var ListenableEventBus
     */
    private $eventBus;

    public function __construct(array $listeners = [])
    {
        $this->eventBus = new ListenableEventBus(new EventBus(), $listeners);

        $this->commandBus = new CommandBus($this->eventBus, [
            new HandleBeginGame($this->eventBus),
            new HandleTakeMove($this->eventBus, new Games($this->eventBus))
        ]);

        $this->eventBus->registerListeners([
            new GameBeganListener($this->commandBus),
            new MoveTakenListener($this->commandBus)
        ]);
    }

    public function playGame()
    {
        $gameId = GameId::createNew();

        $this->commandBus->dispatch(new BeginGame($gameId));
    }
}
