<?php

namespace NoughtsAndCrosses\Automated\Listener;

use NoughtsAndCrosses\Automated\EventListener;
use NoughtsAndCrosses\Core\Command\CommandBus;
use NoughtsAndCrosses\Core\Event\Event;
use NoughtsAndCrosses\Core\MoveNotValid;
use NoughtsAndCrosses\Core\MoveTaken;
use NoughtsAndCrosses\Core\Player;
use NoughtsAndCrosses\Core\Square;
use NoughtsAndCrosses\Core\TakeMove;

class MoveTakenListener implements EventListener
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
        return $event instanceof MoveTaken;
    }

    public function listen(Event $event)
    {
        do {
            try {
                $nextMoveCommand = $this->nextMoveCommand($event);
                $this->commandBus->dispatch($nextMoveCommand);
                $finished = true;
            } catch (MoveNotValid $e) {
                $finished = $e->getCode() == MoveNotValid::REASON_NO_MORE_SPACE;
            }
        } while (!$finished);
    }

    private function nextMoveCommand(MoveTaken $event)
    {
        $player = $event->player() == Player::X() ? Player::O() : Player::X();
        $square = Square::atPosition(
            rand(0, 3),
            rand(0, 3)
        );

        return new TakeMove($event->id(), $square, $player);
    }
}
