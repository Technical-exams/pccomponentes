<?php namespace Basket\Tests\Integration;

use Basket\Application\DataTransformers\Players\PlayerToArrayDataTransformer;
use Basket\Domain\Players\Player;
use Basket\Infrastructure\Players\Doctrine\DoctrinePlayerListCollection;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as TestCase;

class DoctrinePlayerListCollectionTest extends TestCase
{
    /**
     * Data transformer for self::$list
     *
     * @var PlayerToArrayDataTransformer
     */
    protected static $transformer;
    
    /**
     * Collection for test players
     *
     * @var DoctrinePlayerListCollection
     */
    protected static $list;

    public static function setUpBeforeClass() : void{
        self::$transformer = new PlayerToArrayDataTransformer();
        self::$list = new DoctrinePlayerListCollection(self::$transformer);
    }

    public function ValidArrayPlayersProvider(){
        return [
            ["num"=>0, "role"=>"BASE", "rating"=>0, "label"=>"Base 0","created"=>null],
            ["num"=>1, "role"=>"BASE", "rating"=>1, "label"=>"Base 1","created"=>null],
            ["num"=>2, "role"=>"BASE", "rating"=>2, "label"=>"Base 2","created"=>strtotime('now')],
            ["num"=>3, "role"=>"ALERO", "rating"=>3, "label"=>"Alero 3","created"=>strtotime('+1 second')],
            ["num"=>4, "role"=>"ALERO", "rating"=>4, "label"=>"Alero 4","created"=>null],
            ["num"=>5, "role"=>"ALERO", "rating"=>5, "label"=>"Alero 5","created"=>strtotime('now')],
            ["num"=>6, "role"=>"PIVOT", "rating"=>6, "label"=>"Pivot 6","created"=>strtotime('+1 second')],
            ["num"=>7, "role"=>"PIVOT", "rating"=>7, "label"=>"Pivot 7","created"=>null],
            ["num"=>8, "role"=>"PIVOT", "rating"=>8, "label"=>"Pivot 8","created"=>strtotime('now')],
            ["num"=>9, "role"=>"ESCOLTA", "rating"=>9, "label"=>"Escolta 9","created"=>strtotime('+1 second')],
        ];
    }

    public function ValidPlayersProvider(){
        $players = $this->ValidArrayPlayersProvider();
        $transformer = new PlayerToArrayDataTransformer();
        $result = array_map(array($transformer,'createPlayer'),$players);
        $result = array_map(function($player){return [$player];},$result);
        return $result;
    }

    

    /**
     * @dataProvider ValidPlayersProvider
     */
    public function testSetIncreasesCount($player){
        $count = self::$list->count();
        self::$list->set($player->num()->value(),$player);
        $this->assertCount($count+1,self::$list,"Collection::set method does not increase the count");
    }

    /**
     * @depends testSetIncreasesCount
     *
     */
    public function testClearSetsCountToZero(){
        self::$list->clear();
        $this->assertCount(0,self::$list,"Collection::clear method does decrease the count to zero");
    }

    /**
     * @depends testClearSetsCountToZero
     * @dataProvider ValidPlayersProvider
     */
    public function testAddIncreasesCount($player){
        self::$list->clear();
        $count = self::$list->count();
        self::$list->add($player);
        $this->assertCount($count+1,self::$list,"Collection::add method does not increase the count");
    }

    /**
     * @depends testClearSetsCountToZero
     * @dataProvider ValidPlayersProvider
     */
    public function testSetIdempotence($player){
        self::$list->clear();
        $count = self::$list->count();
        self::$list->set($player->num()->value(),$player);
        self::$list->set($player->num()->value(),$player);
        $this->assertCount($count+1,self::$list,"Collection::set method is not idempotent function");
    }

    /**
     * @depends testClearSetsCountToZero
     * @dataProvider ValidPlayersProvider
     */
    public function testAddIdempotence($player){
        self::$list->clear();
        $count = self::$list->count();
        self::$list->add($player);
        self::$list->add($player);
        $this->assertCount($count+1,self::$list,"Collection::add method is not idempotent function");
    }


    /**
     * @depends testClearSetsCountToZero
     * @depends testAddIdempotence
     * @depends testSetIdempotence
     * @dataProvider ValidPlayersProvider
     */
    public function testAddAfterSetHasNoEffect($player){
        self::$list->clear();
        $count = self::$list->count();
        self::$list->set($player->num()->value(),$player);        
        self::$list->add($player);
        $this->assertCount($count+1,self::$list,"Collection::add method after set method, increases the count unexpectedly");
    }

    /**
     * @depends testClearSetsCountToZero
     * @depends testAddIdempotence
     * @depends testSetIdempotence
     * @dataProvider ValidPlayersProvider
     */
    public function testSetAfterAddHasNoEffect($player){
        self::$list->clear();
        $count = self::$list->count();
        self::$list->add($player);
        self::$list->set($player->num()->value(),$player);                
        $this->assertCount($count+1,self::$list,"Collection::set method after add method, increases the count unexpectedly");
    }

    /**
      * @depends testSetAfterAddHasNoEffect      
      */
    public function testFedCollectionIsIterable(){
        $iterator = self::$list->getIterator();
        $this->assertIsIterable($iterator,"Collection is not iterable");
    }

    /**
     * @depends testFedCollectionIsIterable
     * @depends testClearSetsCountToZero
     * @depends testAddIncreasesCount
     */
    public function testCountMatchesNumberOfNewAdditions(){
        self::$list->clear();
        $additions = $this->ValidPlayersProvider();
        
        foreach($additions as $addition){
            self::$list->add(reset($addition));
        }
        $this->assertCount(count($additions),self::$list,"List count method does not count correctly");
    }


    /**
     * @depends testFedCollectionIsIterable
     */
    public function testLastReturnsPlayer(){
        $player = self::$list->last();
        $this->assertInstanceOf(Player::class,$player,"Last function does not return a Player instance");
    }


    /**
     * @depends testFedCollectionIsIterable
     */
    public function testFirstReturnsPlayer(){
        $player = self::$list->first();
        $this->assertInstanceOf(Player::class,$player,"First function does not return a Player instance");
    }

    /**
     * @depends testFirstReturnsPlayer
     */
    public function testNextReturnsPlayer(){
        $player = self::$list->next();
        $this->assertInstanceOf(Player::class,$player,"Next function does not return a Player instance");
    }


    /**
     * @depends testNextReturnsPlayer
     */
    public function testCurrentReturnsPlayer(){
        $player = self::$list->current();
        $this->assertInstanceOf(Player::class,$player,"Current function does not return a Player instance");
    }


    /**
     * @depends testFedCollectionIsIterable
     */
    public function testToArrayReturnsArrayOfPlayers(){
        $array_of_players = self::$list->toArray();
        $this->assertGreaterThan(0,count($array_of_players),"toArray returns an empty array");
        $this->assertEquals(self::$list->count(),count($array_of_players),"toArray returns an empty array");
        $this->assertInstanceOf(Player::class,reset($array_of_players),"toArray does not feed the returned array with Player instances");
    }


    /**
     * @depends testFedCollectionIsIterable
     */
    public function testGetValuesReturnsArrayOfPlayers(){
        $array_of_players = self::$list->getValues();
        $this->assertGreaterThan(0,count($array_of_players),"getValues returns an empty array");        
        $this->assertInstanceOf(Player::class,reset($array_of_players),"toArray does not feed the returned array with Player instances");

    }

    /**
     * @depends testFedCollectionIsIterable
     */
    public function testGetReturnsTheRightPlayer(){
        $player = self::$list->get(8);        
        $this->assertInstanceOf(Player::class,$player,"get does not return a Player Instance");
        $this->assertEquals('PIVOT',$player->role()->value(),"get does not return the right Player");
    }

    /**
     * @depends testFedCollectionIsIterable
     * @depends testAddIncreasesCount
     * @dataProvider ValidPlayersProvider
     */
    public function testIndexOfGetsThePlayerNum($player){
        self::$list->add($player);
        $index = self::$list->indexOf($player);
        $this->assertEquals($player->num()->value(),$index, "indexOf does not return the Player number");        
    }

    /**
     * @depends testFedCollectionIsIterable
     * @dataProvider ValidPlayersProvider
     */
    public function testContainsFindsContainedPlayer($player){
        $result = self::$list->contains($player);
        $this->assertTrue($result, "contains does not find a contained Player");
    }

    /**
     * @depends testContainsFindsContainedPlayer
     * @depends testClearSetsCountToZero
     * @dataProvider ValidPlayersProvider
     */
    public function testContainsDoesNotFindMissingPlayers($player){
        self::$list->clear();
        $this->assertCount(0,self::$list,"List is not empty");
        $result = self::$list->contains($player);
        $this->assertFalse($result, "contains finds a missing Player");
    }

    /**
     * @depends testAddIncreasesCount
     * @depends testContainsDoesNotFindMissingPlayers
     * @dataProvider ValidPlayersProvider
     */
    public function testRemoveElementDropsPlayer($player){
        self::$list->add($player);
        $count = self::$list->count();
        $dropped_player = self::$list->removeElement($player);
        $this->assertTrue($dropped_player,"RemoveElement does not return true when succeeded");
        $contained = self::$list->contains($player);
        $this->assertFalse($contained,"RemoveElement does not remove Players");
        $this->assertCount($count-1,self::$list,"RemoveElement does not decrease the count");
    }

    /**
     * @depends testRemoveElementDropsPlayer
     * @depends testAddIncreasesCount
     * @dataProvider ValidPlayersProvider
     */
    public function testRemoveElementDoesNotDropsMissingPlayer($player){
        self::$list->add($player);
        $dropped_player = self::$list->removeElement($player);
        $count = self::$list->count();
        $missing = self::$list->removeElement($player);
        $this->assertFalse($missing,"RemoveElement of a missing player does not return false when missed");
        $this->assertCount($count,self::$list,"RemoveElement decreases the count");
    }

    /**
     * @depends testSetIncreasesCount
     * @depends testContainsDoesNotFindMissingPlayers
     * @dataProvider ValidPlayersProvider
     */
    public function testRemoveDropsFoundPlayer($player)
    {
        self::$list->set($player->num()->value(),$player);
        $count = self::$list->count();       
        $dropped_player = self::$list->remove($player->num()->value());
        $this->assertInstanceOf(Player::class, $dropped_player,"Remove does not return the Player when succeeded");
        $contained = self::$list->contains($dropped_player);
        $this->assertFalse($contained,"Remove does not remove Players");
        $this->assertCount($count-1,self::$list,"Remove does not decrease the count");        
    }

    /**
     * @depends testSetIncreasesCount
     * @depends testContainsDoesNotFindMissingPlayers
     * @depends testRemoveDropsFoundPlayer
     * @dataProvider ValidPlayersProvider
     */
    public function testRemoveDoesNotDropMissingPlayer($player)
    {
        self::$list->set($player->num()->value(),$player);        
        $dropped_player = self::$list->remove($player->num()->value());
        $count = self::$list->count();
        $missing = self::$list->remove($dropped_player->num()->value());
        $this->assertNull($missing,"Remove does not return null when failed");        
        $this->assertCount($count,self::$list,"Remove decreases the count");        
    }

}