<?php namespace Basket\Domain\Players;

use Basket\Domain\Classes\SingleValueObject;

class PlayerRatingValueObject
    extends SingleValueObject
{

    /**
     * The gathered rating for a player
     *
     * @var int
     */
    protected $value;

    /**
     * {@inheritDoc}
     */
    public function __construct($value)
    {
        $rating = (int)$value;

        if ($rating < 0 || $rating > 100)
            throw new \InvalidArgumentException(sprintf("Bad rating value for player, given '%s'",$rating));

        parent::__construct($rating);
    }

    /**
     * {@inheritDoc}
     */
    public function asScalar()
    {
        return (int)($this->value());
    }

}