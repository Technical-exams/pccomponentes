<?php namespace Basket\Application\RemovePlayer;

use Basket\Application\Command\CommandResponse;
use Basket\Domain\Players\PlayerDTO;

class RemovePlayerResponse
    implements CommandResponse
{

    const ACTION_REMOVED = 'ADDED';
    const ACTION_NOT_FOUND = 'NOT_FOUND';

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
    public function __construct(bool $removed = true, PlayerDTO $player = null)
    {
        $this->player = $player;
        $this->action = $removed ? self::ACTION_REMOVED : self::ACTION_NOT_FOUND;
    }
}