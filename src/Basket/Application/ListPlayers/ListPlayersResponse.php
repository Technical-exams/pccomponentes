<?php namespace Basket\Application\ListPlayers;

use Basket\Application\Command\CommandResponse;

class ListPlayersResponse
    implements CommandResponse
{
    /**
     * (Sorted) Array of players
     *
     * @var array
     */
    public $players;

    /**
     * List Players response constructor
     *
     * @param array $players
     */
    public function __construct(array $players)
    {
        $this->players = $players;
    }
}