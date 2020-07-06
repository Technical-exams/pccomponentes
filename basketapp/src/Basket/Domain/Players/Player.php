<?php namespace Basket\Domain\Players;

use Basket\Domain\Players\PlayerNumValueObject;
use Basket\Domain\Players\PlayerRoleValueObject;
use Basket\Domain\Players\PlayerRatingValueObject;
use Basket\Domain\Players\PlayerCreatedValueObject;                          

/**
 * Player Entity
 * @property PlayerNumValueObject $num
 * @property PlayerRoleValueObject $role
 * @property PlayerRatingValueObject $rating
 * @property PlayerCreatedValueObject $created
 */
class Player
{
    /**
     * T-shirt player number
     *
     * @var PlayerNumValueObject
     */
    protected $num;

    /**
     * T-shirt player name
     *
     * @var string
     */
    protected $label;

    /**
     * Role of the player
     * @var PlayerRoleValueObject
     */
    protected $role;

    /**
     * Rating of the player
     * @var PlayerRatingValueObject
     */
    protected $rating;

    /**
     * Moment in time when the player was registered for the first time
     * @var PlayerCreatedValueObject
     */
    protected $created;

    public function __construct(int $num, string $label, string $role, int $rating, \DateTime $created=null)
    {
        $this->setNum($num)
             ->setLabel($label)
             ->setRole($role)
             ->setRating($rating);

        if (! is_null($created))
            $this->setCreated($created);
        else
            $this->created = new PlayerCreatedValueObject();                    
    }

    public function __set($property,$value)
    {
        $property = strtolower($property);
        if ( in_array($property, ["num", "label", "role", "rating", "created"])){
            $setter = 'set'.ucfirst($property);
            $this->{$setter}($value);
        }
    }

    /**
     * Getter for $num property
     *
     * @return PlayerNumValueObject
     */
    public function num(): PlayerNumValueObject
    {
        return $this->num;
    }

    /**
     * Getter for $label property
     *
     * @return string
     */
    public function label(): string
    {
        return $this->label;
    }

    /**
     * Getter for $role property
     *
     * @return PlayerRoleValueObject
     */
    public function role(): PlayerRoleValueObject
    {
        return $this->role;
    }

    /**
     * Getter for $rating property
     *
     * @return PlayerRatingValueObject
     */
    public function rating(): PlayerRatingValueObject
    {
        return $this->rating;
    }

    /**
     * Getter for $created property
     *
     * @return PlayerCreatedValueObject
     */
    public function created(): PlayerCreatedValueObject
    {
        return $this->created;        
    }

    /**
     * Setter for $num property
     *
     * @param mixed $num
     * @return Player
     * @throws \InvalidArgumentException when $num arg is not valid
     */
    protected function setNum($num){
        $this->num = new PlayerNumValueObject($num);
        return $this;
    }

    /**
     * Setter for $label property
     *
     * @param mixed $label
     * @return Player
     * @throws \InvalidArgumentException whenever $label is not scalar
     */
    protected function setLabel($label){
        if (! is_scalar($label))
            throw new \InvalidArgumentException(sprintf("Bad label value for player, given value of type '%s'",gettype($label)));
        $label = trim((string)$label);
        if (strlen($label) == 0)
            throw new \InvalidArgumentException(sprintf("Bad label value for player, given empty value"));
        $this->label = $label;
        return $this;
    }

    /**
     * Setter for $role property
     *
     * @param mixed $role
     * @return Player
     * @throws \InvalidArgumentException when $role arg is not valid
     */
    protected function setRole($role){
        $this->role = new PlayerRoleValueObject($role);
        return $this;
    }

    /**
     * Setter for $rating property
     *
     * @param mixed $rating
     * @return Player
     * @throws \InvalidArgumentException when $rating arg is not valid
     */
    protected function setRating($rating){
        $this->rating = new PlayerRatingValueObject($rating);
        return $this;
    }    


    /**
     * Setter for $created property
     *
     * @param mixed $created
     * @return Player
     * @throws \InvalidArgumentException when $created arg is not valid
     */
    protected function setCreated($created){
        $this->created = PlayerCreatedValueObject::fromDateTime($created);
        return $this;
    }    

}