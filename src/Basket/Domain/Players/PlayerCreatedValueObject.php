<?php namespace Basket\Domain\Players;

use Basket\Domain\Classes\DateTimeValueObject;

class PlayerCreatedValueObject
    extends DateTimeValueObject
{
    /**
     * Player Created value object constructor
     */
    public function __construct()
    {
        $time = new \DateTime();
        
        parent::__construct($time);
    }


    public static function fromDateTime(\DateTime $created){
        $instance = new static();
        $parent_instance = new DateTimeValueObject($created);
        $instance->value = $parent_instance->value;
        unset($parent_instance);
        return $instance;
    }

}