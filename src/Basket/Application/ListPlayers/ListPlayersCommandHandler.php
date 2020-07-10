<?php namespace Basket\Application\ListPlayers;

use Basket\Application\Command\CommandHandler;
use Basket\Application\Command\CommandTracker;
use Basket\Application\Command\CommandUseCase;

class ListPlayersCommandHandler
    extends CommandHandler
{

    private $service;
    
    public function __construct(ListPlayersUseCase $service, CommandTracker $tracker){
        $this->service = $service;
        parent::__construct($tracker);
    }

    function getService(): CommandUseCase
    {
        return $this->service;
    }        
}