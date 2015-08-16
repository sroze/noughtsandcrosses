<?php

namespace NoughtsAndCrosses\Automated\Listener;

use NoughtsAndCrosses\Automated\EventListener;
use NoughtsAndCrosses\Core\Command\CommandBus;
use NoughtsAndCrosses\Core\Event\Event;
use NoughtsAndCrosses\Core\GameBegan;
use NoughtsAndCrosses\Core\Player;
use NoughtsAndCrosses\Core\Square;
use NoughtsAndCrosses\Core\TakeMove;

class GameBeganListener implements EventListener
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function accept(Event $event)
    {
        return $event instanceof GameBegan;
    }

    public function listen(Event $event)
    {
        $player = rand(0, 1) ? Player::O() : Player::X();
        $square = Square::atPosition(rand(0, 3), rand(0, 3));

        $firstMoveCommand = new TakeMove($event->id(), $square, $player);

        $this->commandBus->dispatch($firstMoveCommand);
    }
}
