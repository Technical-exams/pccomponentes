<?php namespace Basket\Infrastructure\Players\InMemory;

use Basket\Domain\Players\Player;
use Basket\Domain\Players\PlayerNumValueObject;
use Basket\Domain\Players\PlayersRepository;
use Basket\Infrastructure\Common\InMemory\InMemoryDataSource as DataSourceAdapter;

class InMemoryPlayersRepository
    implements PlayersRepository
{

    /**
     * Source of Player Repository Data
     *
     * @var DataSourceAdapter
     */
    protected $dataSource;

    /**
     * Player properties to be used for sorting find results
     *
     * @var array
     */
    protected $sortCriteria;


    /**
     * Creates an instance of Players repository with an Adapter
     * ready to use for data access
     *
     * @param Adapter $dataSource
     */
    public function __construct(DataSourceAdapter $dataSourceAdapter){
        $this->dataSource = $dataSourceAdapter;
    }

    /**
     * {@inheritDoc}
     *
     */
    public function findAll(array $orderBy = [])
    {
        return $this->dataSource->fetchAll($orderBy);
    }

    /**
     * {@inheritDoc}
     * @throws \InvalidArgumentException if Player exists in the repository
     */
    public function add(Player $player)
    {
        $old_player = $this->dataSource->fetchOne($player->num());
        $this->dataSource->insert($player);
        return $old_player;
    }    

    /**
     * {@inheritDoc}
     * @throws \InvalidArgumentException whenever Player identified by $num does not exist in the repository
     */
    public function remove(PlayerNumValueObject $num)
    {
        $player = $this->dataSource->fetchOne($num);
        if ($player instanceof Player)
            $this->dataSource->delete($num);
        return $player;
    }

}