<?php namespace Basket\Application\ListPlayers;

use Basket\Application\Command\CommandRequest;

class ListPlayersRequest
    implements CommandRequest
{
    /**
     * The OrderBy requested criteria, if any
     *
     * @var array
     */
    private $orderBy;

    /** */
    public function __construct(array $orderBy=[]){
        $this->orderBy = $orderBy;
    }

    /**
     * Getter for the orderBy requested
     *
     * @return array
     */
    public function orderBy(): array
    {
        return $this->orderBy;
    }
}