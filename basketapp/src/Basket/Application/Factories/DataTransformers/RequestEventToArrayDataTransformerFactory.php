<?php namespace Basket\Application\Factories\DataTransformers;

use Basket\Application\DataTransformers\Events\RequestEventDataTransformer;
use Basket\Application\DataTransformers\Events\RequestEventToArrayDataTransformer;
use Basket\Application\DataTransformers\Requests\ListPlayersRequestToArrayDataTransformer;
use Basket\Application\DataTransformers\Requests\NewPlayerRequestToArrayDataTransformer;
use Basket\Application\DataTransformers\Requests\RemovePlayerRequestToArrayDataTransformer;

use Basket\Application\Events\RequestEvent;
use Basket\Application\ListPlayers\ListPlayersRequest;
use Basket\Application\NewPlayer\NewPlayerRequest;
use Basket\Application\RemovePlayer\RemovePlayerRequest;

class RequestEventToArrayDataTransformerFactory
{
    public function __invoke(RequestEvent $requestEvent) : RequestEventDataTransformer
    {
        $request_data_transformer = null;
        switch(get_class($requestEvent->request())):
            case NewPlayerRequest::class:
                $request_data_transformer = new NewPlayerRequestToArrayDataTransformer();
            break;
            case RemovePlayerRequest::class:
                $request_data_transformer = new RemovePlayerRequestToArrayDataTransformer();
            break;
            case ListPlayersRequest::class:
                $request_data_transformer = new ListPlayersRequestToArrayDataTransformer();
        endswitch;

        return new RequestEventToArrayDataTransformer($request_data_transformer);
    }
}