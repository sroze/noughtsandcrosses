<?php

namespace NoughtsAndCrosses\Core;

use NoughtsAndCrosses\Core\Event\Event;

class Game
{
    private $events = [];

    private $id;

    private $size;

    private $occupiedSquares = [];

    private $lastPlayer;

    private function __construct(){}

    public static function begin(GameId $identity, $size = 3)
    {
        $game = new static();
        $game->apply(new GameBegan($identity, $size));

        return $game;
    }

    public static function fromEvents(array $events)
    {
        $game = new static();

        foreach ($events as $event) {
            $game->apply($event);
        }

        $game->events = [];

        return $game;
    }

    public function getNewEvents()
    {
        return $this->events;
    }

    public function play(Square $square, Player $player)
    {
        $this->apply(new MoveTaken($this->id, $square, $player));
    }

    private function apply(Event $event)
    {
        if ($event instanceof GameBegan) {
            $this->applyGameBegan($event);
        }
        elseif ($event instanceof MoveTaken) {
            $this->applyMoveTaken($event);
        }

        $this->events[] = $event;
    }

    private function applyGameBegan(GameBegan $gameBegan)
    {
        $this->id = $gameBegan->id();
        $this->size = $gameBegan->size();
    }

    private function applyMoveTaken(MoveTaken $moveTaken)
    {
        if ($this->isFinished()) {
            throw new MoveNotValid('No more space on game', MoveNotValid::REASON_NO_MORE_SPACE);
        }
        if (in_array($moveTaken->square(), $this->occupiedSquares)) {
            throw new MoveNotValid('Square already played', MoveNotValid::REASON_SQUARE_ALREADY_PLAYED);
        }

        if ($moveTaken->player() == $this->lastPlayer) {
            throw new MoveNotValid('Same player played twice in a row', MoveNotValid::REASON_PLAYER_IS_ALREADY_THE_LAST_ONE);
        }

        $this->lastPlayer = $moveTaken->player();
        $this->occupiedSquares[] = $moveTaken->square();
    }

    private function isFinished()
    {
        return count($this->occupiedSquares) === pow($this->size, 2);
    }
}
