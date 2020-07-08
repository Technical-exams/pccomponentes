<?php namespace Basket\Application\Command;

use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command as BaseCommand;

abstract class Command
    extends BaseCommand
{

    /**
     * Application CommandBus
     *
     * @var CommandBus
     */
    private $commandBus;


    /** 
     * Response Output Formatter 
     * 
     * @var OutputFormatter
     */
    private $output_formatter;
    /**
     * Command constructor
     * Creates a command ready to execute the List Players use case
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus){
        $this->commandBus = $commandBus;
        parent::__construct();        
    }

    public function setOutputFormatter(OutputFormatter $formatter){
        $this->output_formatter = $formatter;
    }

    protected function commandBus(){
        return $this->commandBus;
    }

    protected function formatter(){
        return $this->output_formatter;
    }
}