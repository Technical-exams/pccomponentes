<?php namespace Basket\Application\Serializers;

use Basket\Domain\Players\PlayerList;

class BuiltInPlayerListSerializer
    implements PlayerListSerializer
{

    /**
     * {@inheritDoc}
     */
    public function serialize(PlayerList $players){
        return \serialize($players);
    }

    public function unserialize($data): PlayerList
    {
        return \unserialize($data);
    }

    
}