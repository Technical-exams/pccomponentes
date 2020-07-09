<?php namespace Basket\Application\DataTransformers\Players;

use Basket\Domain\Players\PlayerDTO;

class PlayerDTOToJsonDataTransformer
    implements PlayerDTODataTransformer
{

    /**
     * {@inheritDoc}
     */
    public function transform(PlayerDTO $player){
        $array_player = get_object_vars($player);                
        return \json_encode($array_player,\JSON_PRETTY_PRINT,1);
    }

}