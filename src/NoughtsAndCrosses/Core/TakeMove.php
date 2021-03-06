<?php

namespace NoughtsAndCrosses\Core;

use NoughtsAndCrosses\Core\Command\Command;

class TakeMove implements Command
{
    private $id;

    private $square;

    private $player;

    public function __construct(GameId $id, Square $square, Player $player)
    {
        $this->id = $id;
        $this->square = $square;
        $this->player = $player;
    }

    public function id()
    {
        return $this->id;
    }

    public function square()
    {
        return $this->square;
    }

    public function player()
    {
        return $this->player;
    }
}
