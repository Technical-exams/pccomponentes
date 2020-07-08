<?php namespace Basket\Application\Command;


interface CommandUseCase
{
    public function execute(CommandRequest $request) : CommandResponse;
}