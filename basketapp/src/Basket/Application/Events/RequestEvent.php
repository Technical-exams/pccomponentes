<?php namespace Basket\Application\Events;

use Basket\Application\Command\CommandRequest;

class RequestEvent{

    /**
     * The request triggering the Event
     * 
     * @var CommandRequest
     */
    protected $request;

    /**
     * The moment in time when the event was triggered
     *
     * @var int
     */
    protected $timestamp;

    public function __construct(CommandRequest $request){
        $this->request = $request;
        $time = new \DateTimeImmutable();
        $this->timestamp = $time->getTimestamp();
    }

    public function request(): CommandRequest
    {
        return $this->request;
    }

    public function timestamp(): int
    {
        return $this->timestamp;
    }
}