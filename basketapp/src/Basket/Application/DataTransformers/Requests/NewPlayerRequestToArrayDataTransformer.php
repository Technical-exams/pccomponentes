<?php namespace Basket\Application\DataTransformers\Requests;

use Basket\Application\Command\CommandRequest;
use Basket\Application\NewPlayer\NewPlayerRequest;

class NewPlayerRequestToArrayDataTransformer
    implements RequestToArrayDataTransformer
{
    public function transform(CommandRequest $request)
    {
        if (! $request instanceof NewPlayerRequest)
            throw new \InvalidArgumentException("Cannot transform a request other than ".NewPlayerRequest::class);
        return [
            "ADD NEW/UPDATE PLAYER",
            "",
            "NUM:",
            $request->num(),
            "ROLE",
            $request->position(),
            "LABEL",
            $request->label(),
            "RATING",
            $request->rating()
        ];
    }
}