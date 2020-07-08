<?php namespace Basket\Application\Requests;

final class BasicRequestSerializer
    implements RequestSerializer
{
    public function serialize($request)
    {
        return \serialize($request);
    }

    public function unserialize(string $serialized_request)
    {
        return \unserialize($serialized_request);
    }
}