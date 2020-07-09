<?php namespace Basket\Infrastructure\Players\Doctrine;

use Basket\Domain\Players\Player;
use Doctrine\Common\Collections\ArrayCollection;

use Basket\Application\Serializers\PlayerToArraySerializer as ArraySerializer;
use Basket\Domain\Players\PlayerList;
use Basket\Domain\Players\PlayerNumValueObject;
use Doctrine\Common\Collections\Criteria;

class DoctrinePlayerListCollection
    extends ArrayCollection
    implements PlayerList
{
    /**
     * Serializer for Players input/output
     *
     * @var ArraySerializer
     */
    protected $serializer;

    /**
     * List of players already sorted
     * This list is prepared for fetch operations
     *
     * @var ArrayCollection
     */
    protected $sortedList;

    /**
     * Transforms a player using the serializer
     *
     * @param Player $player
     * @return array
     */
    protected function toData(Player $player): array
    {
        return $this->serializer->serialize($player);
    }

    /**
     * Transforms back data onto a Player
     *
     * @param array $player_data
     * @return Player
     */
    protected function toPlayer(array $player_data): Player
    {
        return $this->serializer->unserialize($player_data);
    }

    /**
     * {@inheritDoc}
     */
    public function has(Player $player) : bool
    {
        $array_player = $this->toData($player);
        return $this->containsKey($player->num()->value()) || $this->contains($array_player);
    }

    /**
     * {@inheritDoc}
     */
    public function append(Player $player) : void
    {
        $num = $player->num()->value();
        if ($this->has($player))
            throw new \InvalidArgumentException(sprintf("Player with num %s is already in the player list",$num));
        $array_player = $this->toData($player);        
        $this->set($player->num()->value(),$array_player);
    }

    /**
     * {@inheritDoc}
     */
    public function extract(PlayerNumValueObject $number) : Player
    {
        $result = $this->remove($number->value());
        if (is_null($result))
            throw new \InvalidArgumentException(sprintf("Player with numn %s was not in the player list",$number->value()));
        return $this->toPlayer($result);
    }

    /**
     * {@inheritDoc}
     */
    public function list() : array
    {
        $result = $this->sortedList ? $this->sortedList->toArray() : $this->toArray();        
        $this->sortedList = null;
        return array_map( array($this,'toPlayer'), $result );
    }

    public function sort(string $property = "") : void
    {
        if (!empty($property)) {
            $criteria = new Criteria();
            $criteria->orderBy([$property => Criteria::ASC]);
            $this->sortedList = $this->matching($criteria);
        }else{
            $this->sortedList = null;    
        }
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $data = [];
        $this->serializer = new ArraySerializer();
        if (func_num_args()>0 && is_array(func_get_arg(0)))
            $data = func_get_arg(0);
        parent::__construct($data);
    }

    /**
     * {@inheritDoc}
     */
    protected function createFrom(array $players)
    {        
        $result = new static($this->serializer);
        foreach($players as $player)
            $result->set($player['num'],$player);
        return $result;
    }


    /**
     * Sets a player in the collection
     * placed at the given $key position
     *
     * @param mixed $key
     * @param array $player
     * @return void
     */
    public function set($key, $player){
        if ( !is_array($player))
            throw new \InvalidArgumentException("\$player must be an associative array");
        if ( !array_key_exists('num',$player))
            throw new \InvalidArgumentException("\$player must have 'num'");
        if ($player['num'] != $key)
            throw new \InvalidArgumentException(sprintf("\$key must contain \$player num. Expected %s, given %s",$player['num'] ,$key));        
        return parent::set($key,$player);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {        
        return new \ArrayIterator($this->toArray());
    }


   
    /**
     * Required by interface ArrayAccess.
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {        
        return $this->toPlayer(parent::offsetGet($offset));
    }

    /**
     * Required by interface ArrayAccess.
     * 
     * @param mixed $offset
     * @param Player $value
     * @throws \InvalidArgumentException if $value is not a Player instance
     */
    public function offsetSet($offset, $value)
    {
        if (!($value instanceof Player)) 
            throw new \InvalidArgumentException("Can only set Players in the Player List");
        
        if (! isset($offset)) {
            $this->append($value);
            return;
        }
        $this->set($offset, $value);
    }

}