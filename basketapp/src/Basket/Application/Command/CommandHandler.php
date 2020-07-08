<?php namespace Basket\Application\Command;

abstract class CommandHandler
{
    /**
     * Tracker for command requests
     *
     * @var CommandTracker
     */
    private $tracker;
    
    public function __construct(CommandTracker $tracker){
        $this->tracker = $tracker;
    }

    abstract function getService(): CommandUseCase;

    public function handle(CommandRequest $request): CommandResponse
    {
        $this->tracker->track($request);
        return $this->getService()->execute($request);
    }

}