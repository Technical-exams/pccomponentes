<?php namespace Basket\Domain\Players;


class PlayerDTO
{
    /**
     * T-shirt player number
     * @var int
     */
    public $num;

    /**
     * T-shirt player name
     * @var string
     */
    public $label;

    /**
     * Role of the player
     * @var string
     */
    public $role;

    /**
     * Rating of the player
     * @var int
     */
    public $rating;

    /**
     * Moment in time when the player was registered for the first time
     * @var int
     */
    public $created;

    public function __construct(Player $player)
    {
        $this->num = $player->num()->asScalar();
        $this->label = $player->label();
        $this->role = $player->role()->asScalar();
        $this->created = $player->created()->asScalar();
    }
    
}