<?php namespace Basket\Application\DataTransformers\Requests;

use Basket\Application\Command\CommandRequest;
use Basket\Application\ListPlayers\ListPlayersRequest;

class ListPlayersRequestToArrayDataTransformer
    implements RequestToArrayDataTransformer
{
    public function transform(CommandRequest $request)
    {
        if (! $request instanceof ListPlayersRequest)
            throw new \InvalidArgumentException("Cannot transform a request other than ".ListPlayersRequest::class);
        return [
            "LIST PLAYERS",
        ];
    }
}