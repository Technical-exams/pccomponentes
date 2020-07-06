<?php namespace Basket\Domain\Classes;

class DateTimeValueObject
    extends SingleValueObject
{

    /**
     * The time object gathered
     *
     * @var \DateTimeImmutable
     */
    protected $value;

    /**
     * {@inheritDoc}
     */
    public function __construct(\DateTime $value)
    {
        $time = \DateTimeImmutable::createFromMutable($value);
    }

    /**
     * {@inheritDoc}
     */
    public function toScalar()
    {
        return $this->value()->getTimestamp();
    }

}