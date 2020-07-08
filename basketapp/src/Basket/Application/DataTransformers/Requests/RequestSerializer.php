<?php namespace Basket\Application\Requests;

interface RequestSerializer{
    public function serialize($request);    

    public function unserialize(string $serialized_request);
}