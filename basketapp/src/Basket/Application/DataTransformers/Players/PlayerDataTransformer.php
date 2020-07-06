<?php namespace Basket\Application\DataTransformers\Players;

use Basket\Domain\Players\Player;

interface PlayerDataTransformer
{

    /**
     * Transforms a player into another structured type
     *
     * @param Player $player
     * @return array|object The transformed player
     */
    public function transform(Player $player);

    /**
     * Creates a player entity from structured data
     *
     * @param array|object $data
     * @return Player
     */
    public function createPlayer($data) : Player;
}