<?php namespace Basket\Infrastructure\Command\Tactician;

use Basket\Application\Command\CommandTracker;
use Basket\Application\Events\RequestEvent;
use Basket\Application\Events\RequestEventHandler;
use League\Tactician\Middleware;

class TacticianMiddlewareRequestEventHandler
    implements RequestEventHandler,
               Middleware
{

    /**
     * The tracker where the request must be annotated
     *
     * @var CommandTracker
     */
    protected $tracker;

    public function __construct(CommandTracker $command_tracker)
    {
        $this->tracker = $command_tracker;
    }

    public function getCommandTracker(): CommandTracker
    {
        return $this->tracker;
    }

    public function execute($command_request, callable $next)
    {
        $event = new RequestEvent($command_request);
        $this->tracker->track($event);        
        return $next($command_request);
    }
}