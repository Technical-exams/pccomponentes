<?php namespace Basket\Tests\Unit;


use Basket\Domain\Players\Player;
use Basket\Domain\Players\PlayerCreatedValueObject;
use Basket\Domain\Players\PlayerRoleValueObject;
use Basket\Domain\Players\PlayerRatingValueObject;
use Basket\Domain\Players\PlayerNumValueObject;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as TestCase;

class PlayerTest extends TestCase
{
    protected $num;
    protected $label;
    protected $rating;
    protected $role;

    protected $player;

    protected function setUp() : void
    {
        $this->num = 99;
        $this->label = ' Joker ';
        $this->rating = 99;
        $this->role = PlayerRoleValueObject::PIVOT;

        $this->player = new Player($this->num, $this->label, $this->role, $this->rating);
        $this->time = new \DateTimeImmutable('now');
    }

    public function testNumProperty(){
        $this->assertInstanceOf(PlayerNumValueObject::class,$this->player->num(),"Test player does not contain a valid \$num type");
        $this->assertSame($this->num,$this->player->num()->value(),"Test player does not have a valid \$num value");
    }

    public function testRoleProperty(){
        $this->assertInstanceOf(PlayerRoleValueObject::class,$this->player->role(),"Test player does not contain a valid \$role type");
        $this->assertSame($this->role,$this->player->role()->value(),"Test player does not have a valid \$role value");
    }

    public function testRatingProperty(){
        $this->assertInstanceOf(PlayerRatingValueObject::class,$this->player->rating(),"Test player does not contain a valid \$rating type");
        $this->assertSame($this->rating,$this->player->rating()->value(),"Test player does not have a valid \$rating value");
    }

    public function testLabelProperty(){
        $this->assertIsString($this->player->label(),"Test player does not contain a valid \$label type");
        $this->assertSame(trim($this->label),$this->player->label(),"Test player does not have a valid \$label value");
    }

    public function testCreatedProperty(){        
        $this->assertInstanceOf(PlayerCreatedValueObject::class,$this->player->created(), "Test player does not contain a valid \$created type");
        $this->assertLessThanOrEqual( 
            1,
            $this->time->getTimestamp() - $this->player->created()->asScalar(), 
            "Test player does not contain a valid \$created value"
        );
    }

    public function testNumLowerThanZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->player->num = -1;
    }

    public function testNumUpperThanMax()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->player->num = PHP_INT_MAX +1 ;
    }

    public function testNewNum()
    {
        $this->player->num = 100;
        $this->assertSame(100, $this->player->num()->value(), "Cannot assign a new value to test player \$num property");
    }

    public function testEmptyLabel()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->player->label = "";
    }

    public function testNonScalarLabel()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->player->label = ["label"];
    }

    public function testNewLabel()
    {
        $this->player->label = 'BATMAN';
        $this->assertSame('BATMAN',$this->player->label(),"Cannot assign a new value to test player \$label property");
    }

    public function testUnexistingRole()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->player->role = "POINTGUARD";
    }

    public function testNewRole()
    {
        $this->player->role = PlayerRoleValueObject::ESCOLTA;
        $this->assertSame(PlayerRoleValueObject::ESCOLTA, $this->player->role()->value(), "Cannot assign a new value to test player \$role property");
    }

    public function testRatingLowerThanZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->player->rating = -88;
    }

    public function testRatingUpperThanHundred()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->player->rating = 101;
    }

    public function testNewRating()
    {        
        $this->player->rating = 2;
        $this->assertSame(2,$this->player->rating()->value(),"Cannot assigna new value to test player \$rating property");
    }


    public function testSetCreatedANewDate()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->player->rating = 101;
    }

    public function testNewCreated()
    {
        $newTime = new \DateTime('last thursday');
        $this->player->created = new \DateTime('last thursday');
        $this->assertEquals($newTime,$this->player->created()->value());
    }

}