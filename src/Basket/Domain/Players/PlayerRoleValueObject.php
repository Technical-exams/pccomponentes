<?php namespace Basket\Domain\Players;

use Basket\Domain\Classes\SingleValueObject;

class PlayerRoleValueObject
    extends SingleValueObject
{
    const BASE = 'BASE';
    const ESCOLTA = 'ESCOLTA';
    const ALERO = 'ALERO';
    const ALA_PIVOT = 'ALA-PIVOT';
    const PIVOT = 'PIVOT';

    /**
     * The gathered role for a player
     *
     * @var string
     */
    protected $value;

    /**
     * {@inheritDoc}
     */
    public function __construct($value)
    {
        $role = strtoupper((string)$value);

        if (! in_array($role, [self::BASE, self::ESCOLTA, self::ALERO, self::ALA_PIVOT, self::PIVOT]))
            throw new \InvalidArgumentException(sprintf("Invalid role for a player, given '%s'", $role));

        parent::__construct($role);
    }

    /**
     * {@inheritDoc}
     */
    public function asScalar()
    {
        return (string)($this->value());
    }

}