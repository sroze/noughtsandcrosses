<?php

include __DIR__.'/../vendor/autoload.php';

use NoughtsAndCrosses\Automated\GameManager;
use NoughtsAndCrosses\Console\EventLoggingListener;

$manager = new GameManager([
    new EventLoggingListener()
]);
$manager->playGame();
