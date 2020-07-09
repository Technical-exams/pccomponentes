<?php namespace Basket\Application\RemovePlayer;

use Basket\Application\Command\CommandHandler;
use Basket\Application\Command\CommandTracker;
use Basket\Application\Command\CommandUseCase;

class RemovePlayerCommandHandler
    extends CommandHandler
{

    private $service;
    
    public function __construct(RemovePlayerUseCase $service, CommandTracker $tracker){
        $this->service = $service;
        parent::__construct($tracker);
    }

    function getService(): CommandUseCase
    {
        return $this->service;
    }        
}