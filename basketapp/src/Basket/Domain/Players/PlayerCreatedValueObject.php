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

}