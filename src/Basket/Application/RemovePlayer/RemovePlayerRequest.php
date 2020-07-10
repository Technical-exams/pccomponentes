<?php namespace Basket\Application\RemovePlayer;

use Basket\Application\Command\CommandRequest;

class RemovePlayerRequest
    implements CommandRequest
{
    
    protected $num;
    
    public function __construct(int $num){
        $this->num = $num;
    }

    /**
     * Getter for $num
     *
     * @return int
     */
    public function num(): int
    {
        return $this->num;
    }
}