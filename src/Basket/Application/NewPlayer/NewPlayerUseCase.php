<?php namespace Basket\Application\NewPlayer;

use Basket\Application\Command\CommandRequest;
use Basket\Application\Command\CommandResponse;
use Basket\Application\Command\CommandUseCase;
use Basket\Domain\Players\PlayersRepository;

use Basket\Domain\Players\Player;
use Basket\Domain\Players\PlayerDTO;

class NewPlayerUseCase
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
     * @param NewPlayerRequest $request
     * @return NewPlayerResponse
     */
    public function execute(CommandRequest $request) : CommandResponse
    {
        if ( ! ($request instanceof NewPlayerRequest) )
            throw new \InvalidArgumentException("Bad command request received. It must be an instance of NewPlayerRequest");


        $num = $request->num();
        $label = $request->label();
        $role = $request->position();
        $rating = $request->rating();

        $new_player = new Player($num,$label,$role,$rating);
        $former_player = $this->repository->add($new_player);

        $dto_player = new PlayerDTO($new_player);
    
        $response = new NewPlayerResponse($dto_player,!is_null($former_player));
        return $response;
    }
}