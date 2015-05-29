<?php

namespace NoughtsAndCrosses\Core;

use NoughtsAndCrosses\Core\Event\Event;

class GameBegan implements Event
{
    private $id;

    /**
     * @var int
     */
    private $size;

    public function __construct(GameId $id, $size)
    {
        $this->id = $id;
        $this->size = $size;
    }

    public function id()
    {
        return $this->id;
    }

    public function size()
    {
        return $this->size;
    }

    public function __toString()
    {
        return 'Game #'.$this->id->__toString();
    }
}
