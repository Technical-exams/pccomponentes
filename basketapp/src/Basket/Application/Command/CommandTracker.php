<?php namespace Basket\Application\Command;

use Basket\Application\Requests\RequestSerializer;

interface CommandTracker
{
    public function __construct(RequestSerializer $serializer);

    public function track($request);

    public function bulk(): array;
}