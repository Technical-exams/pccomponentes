<?php namespace Basket\Infrastructure\Players\Doctrine;

use Basket\Domain\Players\Player;
use Basket\Domain\Players\PlayerNumValueObject;
use Basket\Infrastructure\Common\InMemory\InMemoryDataSource;

class DoctrineInMemoryPlayerDataSource
    implements InMemoryDataSource
{
    protected $collection;

    public function __construct()
    {
        $this->collection = new DoctrinePlayerListCollection();
    }

    /**
     * Fetch all players from the DataSource
     *
     * @param array $orderBy Array with the names of those Player properties names to be used for sorting the results. 
     *                       Must be left empty to not sort the results
     * @return void
     * @throws \InvalidArgumentException if $orderBy has more than one property name
     */
    public function fetchAll(array $orderBy) : array
    {
        if (count($orderBy) > 1)
            throw new \InvalidArgumentException("Multiple player properties not supported as order by criteria");
        elseif (count($orderBy) == 1){
            $property = (string)(reset($orderBy));
            $this->collection->sort($property);
        }
        return $this->collection->list();        
    }

    /**
     * Fetch a players from the DataSource
     *
     * @param  PlayerNumValueObject $num The Player number
     * @return Player | null
     */
    public function fetchOne($num)
    {
        if (isset($this->collection[$num->value()] ) ) //|| array_key_exists($num->value(),$this->collection))
            return $this->collection[$num->value()];
        else
            return null;
    }

    /**
     * Inserts a player in the DataSource
     *
     * @param Player $player
     * @return void
     * @throws \InvalidArgumentException whenever $player is not a Player instance or had been already inserted
     */
    public function insert($player)
    {
        if (! ($player instanceof Player))
            throw new \InvalidArgumentException("Only Player instances can be inserted");
        $this->collection->append($player);
    }

    /**
     * Removes a player from the DataSource
     *
     * @param  PlayerNumValueObject $num The Player Number
     * @return void
     * @throws \InvalidArgumentException whenever $num is not a PlayerNum instance or not present in the datasource
     */
    public function delete($num)
    {
        if (! ($num instanceof PlayerNumValueObject))
            throw new \InvalidArgumentException("Expected type ${PlayerNumValueObject::class} for num of the player to be deleted" );
        $this->collection->extract($num);
    }
}
