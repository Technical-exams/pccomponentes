<?php namespace Basket\Application\NewPlayer;

use Basket\Application\Command\CommandHandler;
use Basket\Application\Command\CommandTracker;
use Basket\Application\Command\CommandUseCase;

class NewPlayerCommandHandler
    extends CommandHandler
{

    private $service;
    
    public function __construct(NewPlayerUseCase $service, CommandTracker $tracker){
        $this->service = $service;
        parent::__construct($tracker);
    }

    function getService(): CommandUseCase
    {
        return $this->service;
    }        
}