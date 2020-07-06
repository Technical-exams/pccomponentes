<?php namespace Basket\Tests\Unit;


use Basket\Domain\Players\Player;
use Basket\Domain\Players\PlayerRoleValueObject;
use Basket\Application\DataTransformers\Players\PlayerToArrayDataTransformer;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as TestCase;

class PlayerToArrayDataTransformerTest extends TestCase
{
    protected $num;
    protected $label;
    protected $rating;
    protected $role;
    protected $time;

    protected $player;
    protected $dataTransformer;

    protected function setUp() : void
    {
        $this->num = 99;
        $this->label = ' Joker ';
        $this->rating = 99;
        $this->role = PlayerRoleValueObject::PIVOT;
        $this->time = new \DateTime('now');
        $this->player = new Player($this->num, $this->label, $this->role, $this->rating, $this->time);

        $this->dataTransformer = new PlayerToArrayDataTransformer();
    }

    public function testTransformReturnsAnArray(){
        $result = $this->dataTransformer->transform($this->player);
        $this->assertIsArray($result,"Data transformer does not return an array when calling transform");
    }

    public function testTransformReturnsAnArrayWithPropertiesAsKeys(){
        $result = $this->dataTransformer->transform($this->player);
        $this->assertArrayHasKey("num",$result, "Data transformer transform result does not contain 'num'");
        $this->assertArrayHasKey("role",$result, "Data transformer transform result does not contain 'role'");
        $this->assertArrayHasKey("created",$result, "Data transformer transform result does not contain 'created'");        
        $this->assertArrayHasKey("rating",$result, "Data transformer transform result does not contain 'rating'");
        $this->assertArrayHasKey("label",$result, "Data transformer transform result does not contain 'label'");                
    }


    public function testAllPropertiesAreTransformedToScalar()
    {
        $transformedPlayer = $this->dataTransformer->transform($this->player);        
        $this->assertSame($this->num, $transformedPlayer['num'], "Data transformer does not fill 'num' with the expected value");
        $this->assertSame(trim($this->label), $transformedPlayer['label'], "Data transformer does not fill 'label' with the expected value");
        $this->assertSame($this->rating, $transformedPlayer['rating'], "Data transformer does not fill 'rating' with the expected value");
        $this->assertSame($this->role, $transformedPlayer['role'], "Data transformer does not fill 'role' with the expected value");
        $this->assertSame($this->time->getTimestamp(), $transformedPlayer['created'], "Data transformer does not fill 'created' with the expected value");
    }
    

}