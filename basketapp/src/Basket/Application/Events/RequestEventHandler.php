<?php namespace Basket\Application\Events;

use Basket\Application\Command\CommandTracker;

interface RequestEventHandler
{
    public function getCommandTracker(): CommandTracker;
}