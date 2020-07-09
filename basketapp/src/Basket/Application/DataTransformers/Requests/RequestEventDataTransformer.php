<?php namespace Basket\Application\DataTransformers\Requests;

use Basket\Application\Command\CommandRequest;

interface RequestEventDataTransformer{

    public function transform(CommandRequest $request);    
}