<?php namespace Basket\Application\Command;

use Basket\Application\Events\RequestEvent;
use Basket\Application\Factories\DataTransformers\RequestEventDataTransformerFactory;

abstract class CommandTracker
{

    /**
     * Factory for creating the right transformer for each RequestEvent
     *
     * @var RequestEventDataTransformerFactory
     */
    protected $factory;

    public function __construct(RequestEventDataTransformerFactory $factory){
        $this->factory = $factory;
    }

    protected function getTransformer(RequestEvent $commandEvent){
        return ($this->factory)($commandEvent);
    }

    abstract public function track(RequestEvent $commandEvent);    
}