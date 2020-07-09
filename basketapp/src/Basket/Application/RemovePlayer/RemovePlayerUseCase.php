<?php namespace Basket\Application\RemovePlayer;

use Basket\Application\Command\CommandRequest;
use Basket\Application\Command\CommandResponse;
use Basket\Application\Command\CommandUseCase;
use Basket\Domain\Players\PlayersRepository;

use Basket\Domain\Players\Player;
use Basket\Domain\Players\PlayerDTO;
use Basket\Domain\Players\PlayerNumValueObject;

class RemovePlayerUseCase
    implements CommandUseCase
{

    /**
     * Repository of players
     *
     * @var PlayersRepository
     */
    protected $repository;

    /**
     * Creates a List-Players Use Case
     */
    public function __construct(PlayersRepository $repository){
        $this->repository = $repository;
    }

    /**
     * Undocumented function
     *
     * @param RemovePlayerRequest $request
     * @return RemovePlayerResponse
     */
    public function execute(CommandRequest $request) : CommandResponse
    {
        if ( ! ($request instanceof RemovePlayerRequest) )
            throw new \InvalidArgumentException("Bad command request received. It must be an instance of RemovePlayerRequest");


        $num = $request->num();

        $player_num = new PlayerNumValueObject($num);
        $former_player = $this->repository->remove($player_num);

        $dto_player = !is_null($former_player) ? new PlayerDTO($former_player) : null;
    
        $response = new RemovePlayerResponse(!is_null($former_player),$dto_player);
        return $response;
    }
}