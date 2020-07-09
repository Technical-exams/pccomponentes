<?php namespace Basket\Application\Factories\DataTransformers;

use Basket\Application\DataTransformers\Events\RequestEventDataTransformer;
use Basket\Application\Events\RequestEvent;

interface RequestEventDataTransformerFactory
{
    public function __invoke(RequestEvent $requestEvent) : RequestEventDataTransformer;
}