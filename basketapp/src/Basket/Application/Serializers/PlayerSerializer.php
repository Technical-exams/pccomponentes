<?php namespace Basket\Application\Serializers;

use Basket\Domain\Players\Player;

interface PlayerSerializer
{
    public function serialize(Player $player);

    public function unserialize($data) : Player;
}