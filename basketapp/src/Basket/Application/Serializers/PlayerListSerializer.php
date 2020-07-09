<?php namespace Basket\Application\Serializers;

use Basket\Domain\Players\PlayerList;

interface PlayerListSerializer
{

    /**
     * Serializes a PlayerList
     *
     * @param PlayerList $players
     * @return void
     */
    public function serialize(PlayerList $players);

    /**
     * Deserializes a PlayerList previously serialized
     *
     * @param mixed $data
     * @return PlayerList $players     
     */
    public function unserialize($data): PlayerList;

}