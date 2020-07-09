<?php namespace Basket\Application\DataTransformers\Events;

use Basket\Application\Command\CommandRequest;
use Basket\Application\DataTransformers\Requests\RequestToArrayDataTransformer;
use Basket\Application\Events\RequestEvent;

class RequestEventToArrayDataTransformer
    implements RequestEventDataTransformer
{

    /**
     * Request to array transformer
     *
     * @var RequestToArrayDataTransformer
     */
    protected $request_transformer;

    public function __construct(RequestToArrayDataTransformer $request_transformer){
        $this->request_transformer = $request_transformer;
    }

    public function transform(RequestEvent $requestEvent)
    {
        $time = new \DateTime('@'.$requestEvent->timestamp());
        $request_data = $this->requestToArray($requestEvent->request());
        $event_data = [$time->format('c')];
        
        return array_merge($event_data, $request_data);
    }

    protected function requestToArray(CommandRequest $request): array
    {
        return $this->request_transformer->transform($request);
    }
}