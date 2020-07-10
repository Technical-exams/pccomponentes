<?php namespace Basket\Infrastructure\Players\Doctrine;

use Basket\Application\Serializers\PlayerListSerializer;
use Basket\Application\Serializers\PlayerSerializer;
use Basket\Domain\Players\PlayerList;

class BuiltInPlayerListSerializer
    implements PlayerListSerializer
{

    protected $player_serializer;

    public function __construct(PlayerSerializer $playerSerializer){
        $this->player_serializer = $playerSerializer;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize(PlayerList $players){
        if (! $players instanceof DoctrinePlayerListCollection)
            throw new \InvalidArgumentException("Don't know how to serialize a PlayerList other than DoctrinePlayerListCollection");
        $array_of_players = $players->toArray();
        return \serialize($array_of_players);
    }

    public function unserialize($data): PlayerList
    {
        $array_of_players = \unserialize($data);
        return new DoctrinePlayerListCollection($array_of_players);
    }

    
}