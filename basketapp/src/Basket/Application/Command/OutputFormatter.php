<?php namespace Basket\Application\Command;

class OutputFormatter
{
    protected $dataTransformer;

    public function __construct($dataTransformer){
        $this->dataTransformer = $dataTransformer;
    }

    public function format($response){
        $output = $this->dataTransformer->transform($response);
        return $output;
    }
}