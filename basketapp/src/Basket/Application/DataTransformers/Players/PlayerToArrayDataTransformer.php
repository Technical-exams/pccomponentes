<?php namespace Basket\Application\DataTransformers\Players;

use Basket\Domain\Players\Player;

class PlayerToArrayDataTransformer
    implements PlayerDataTransformer
{

    /**
     * {@inheritDoc}
     */
    public function transform(Player $player){
        return [
            "num" => $player->num()->asScalar(),
            "role" => $player->role()->asScalar(),
            "label" => $player->label(),
            "rating" => $player->rating()->asScalar(),
            "created" => $player->created()->asScalar()
        ];
    }
}