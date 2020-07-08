<?php namespace Basket\Application\ListPlayers;

use Basket\Application\Command\OutputFormatter;

class ListPlayersOutputFormatter
    extends OutputFormatter
{
    public function format($response){
        $output = parent::format($response);
        $output = str_replace('\\n','',$output);
        $output = str_replace('\\','',$output);
        return $output;
    }
}