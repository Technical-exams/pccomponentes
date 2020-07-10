<?php namespace Basket\Application\DataTransformers\Events;

use Basket\Application\Events\RequestEvent;

interface RequestEventDataTransformer{

    public function transform(RequestEvent $requestEvent);
}