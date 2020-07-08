<?php namespace Basket\Application\ListPlayers;

use Basket\Application\Command\CommandRequest;
use Basket\Application\Command\CommandResponse;
use Basket\Application\Command\CommandUseCase;
use Basket\Domain\Players\PlayersRepository;


class ListPlayersUseCase
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
     * @param ListPlayersRequest $request
     * @return ListPlayersResponse
     */
    public function execute(CommandRequest $request) : CommandResponse
    {
        if ( ! ($request instanceof ListPlayersRequest) )
            throw new \InvalidArgumentException("Bad command request received. It must be an instance of ListPlayersRequest");

        if (!empty($request->orderBy()) && is_array($request->orderBy())){
            $result = $this->repository->findAll($request->orderBy());
        }else{
            $result = $this->repository->findAll();
        }
        
        $response = new ListPlayersResponse($result);
        return $response;
    }
}