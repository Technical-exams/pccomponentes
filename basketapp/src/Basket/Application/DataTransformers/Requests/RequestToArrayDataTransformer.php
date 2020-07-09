<?php namespace Basket\Application\DataTransformers\Requests;

use Basket\Application\Command\CommandRequest;

interface RequestToArrayDataTransformer{

    public function transform(CommandRequest $request);    
}