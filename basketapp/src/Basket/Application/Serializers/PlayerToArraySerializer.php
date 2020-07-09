<?php namespace Basket\Application\Serializers;

use Basket\Domain\Players\Player;

class PlayerToArraySerializer
    implements PlayerSerializer
{

    /**
     * {@inheritDoc}
     */
    public function serialize(Player $player){
        return [
            "num" => $player->num()->asScalar(),
            "role" => $player->role()->asScalar(),
            "label" => $player->label(),
            "rating" => $player->rating()->asScalar(),
            "created" => $player->created()->asScalar()
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($data) : Player
    {
        $created = null;
        if (array_key_exists('created',$data) && is_int($data['created'])){            
            $created = new \DateTime('@'.((string)$data['created']));
        }            
        return new Player($data['num'], $data['label'],$data['role'],$data['rating'], $created);
    }
}