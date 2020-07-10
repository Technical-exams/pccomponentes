<?php namespace Basket\Application\NewPlayer;

use Basket\Application\Command\CommandResponse;
use Basket\Domain\Players\PlayerDTO;

class NewPlayerResponse
    implements CommandResponse
{

    const ACTION_ADDED = 'ADDED';
    const ACTION_UPDATED = 'UPDATED';

    /**
     * Applicaton registered player data
     *
     * @var PlayerDTO
     */
    public $player;

    /**
     * Tells if player has been Added or Updated
     *
     * @var string 
     */
    public $action;

    /**
     * Response constructor
     *
     * @param PlayerDTO $player
     * @param bool $updated
     */
    public function __construct(PlayerDTO $player,bool $updated = false)
    {
        $this->player = $player;
        $this->action = $updated ? self::ACTION_UPDATED : self::ACTION_ADDED;
    }
}