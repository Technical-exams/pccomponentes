<?php namespace Basket\Tests\Unit;

use Basket\Domain\Players\PlayerCreatedValueObject;
use Symfony\Component\Console\Command\Command;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as TestCase;

class PlayerCreatedValueObjectTest extends TestCase
{
    public function testValueIsDatetimeForNewInstances(){
        $created = new PlayerCreatedValueObject();
        $this->assertInstanceOf(\DateTimeImmutable::class,$created->value(),'PlayerCreatedValueObject value is not a DateTimeImmutable');
    }

    public function testFromDateTimeReturnsPlayerCreatedValueObject(){
        $time = new \DateTime('a week ago');
        $created = PlayerCreatedValueObject::fromDateTime($time);
        $this->assertInstanceOf(PlayerCreatedValueObject::class,$created,'PlayerCreatedValueObject::fromDatetime does not create the right ValueObject');
    }

    public function testFromDateTimeObjectContainsTheRightValue(){
        $time = new \DateTime('a week ago');
        $time2 = clone $time;
        $created = PlayerCreatedValueObject::fromDateTime($time);
        $this->assertEquals($created->value(),$time2,'PlayerCreatedValueObject::fromDatetime does not gather the right DateTime Value');
    }

    public function testAsScalarReturnsTimeStamp(){
        $time = new \DateTime('a year ago');
        $created = PlayerCreatedValueObject::fromDateTime($time);
        $this->assertIsInt($created->asScalar(),get_class($created).'::asScalar does not return a UNIX timestamp value');
        $this->assertEquals($created->asScalar(),$time->getTimestamp(), get_class($created).'::asScalar does not return the right timestamp value');
    }

}