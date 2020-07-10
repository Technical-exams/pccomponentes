<?php namespace Basket\Application\DataTransformers\Players;

use Basket\Domain\Players\PlayerDTO;

interface PlayerDTODataTransformer
{

    /**
     * Transforms a player into another structured type
     *
     * @param PlayerDTO $player
     * @return array|object The transformed player
     */
    public function transform(PlayerDTO $player);
}