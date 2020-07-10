<?php namespace Basket\Domain\Classes;

abstract class SingleValueObject
{

    /**
     * The value to gather
     *
     * @var mixed
     */
    protected $value;

    /**
     * Value object constructor
     *
     * @param mixed $value The Value to gather
     */
    public function __construct($value){
        $this->value = $value;
    }

    /**
     * Returns the gathered value once cast into an scalar type
     * predefined by the Value Object class itself
     *
     * @return scalar
     */
    public function asScalar(){
        return \serialize($this->value());
    }

    /**
     * Returns the gathered value
     * 
     * @return mixed
     */
    public function value(){
        return $this->value;
    }

    /**
     * Reveals if two value objects are equal
     *
     * @param SingleValueObject $valueObject
     * @return boolean
     */
    public function equals(SingleValueObject $valueObject) : bool
    {
        return ($this->asScalar() == $valueObject->asScalar());
    }


}