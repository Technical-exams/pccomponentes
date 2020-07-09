<?php namespace Basket\Application\DataTransformers\Requests;

use Basket\Application\Command\CommandRequest;
use Basket\Application\RemovePlayer\RemovePlayerRequest;

class RemovePlayerRequestToArrayDataTransformer
    implements RequestToArrayDataTransformer
{
    public function transform(CommandRequest $request)
    {
        if (! $request instanceof RemovePlayerRequest)
            throw new \InvalidArgumentException("Cannot transform a request other than ".RemovePlayerRequest::class);
        return [
            "REMOVE PLAYER",
            "",
            "NUM:",
            $request->num()
        ];
    }
}