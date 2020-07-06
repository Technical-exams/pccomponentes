<?php namespace Bakset\Domain\Players;

use Basket\Domain\Classes\SingleValueObject;

class PlayerNumValueObject
    extends SingleValueObject
{

    /**
     * The gathered number for a player
     *
     * @var int
     */
    protected $value;

    /**
     * {@inheritDoc}
     */
    public function __construct($value)
    {
        $number = (int)$value;

        if ($number < 0 || $number > PHP_INT_MAX)
            throw new \InvalidArgumentException(sprintf("Bad number value for player, given '%s'",$number));

        parent::__construct($number);
    }

    /**
     * {@inheritDoc}
     */
    public function asScalar()
    {
        return (int)($this->value());
    }

}