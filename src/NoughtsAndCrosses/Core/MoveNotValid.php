<?php

namespace NoughtsAndCrosses\Core;

class MoveNotValid extends \Exception
{
    const REASON_NO_MORE_SPACE = 1;
    const REASON_SQUARE_ALREADY_PLAYED = 2;
    const REASON_PLAYER_IS_ALREADY_THE_LAST_ONE = 3;
}
