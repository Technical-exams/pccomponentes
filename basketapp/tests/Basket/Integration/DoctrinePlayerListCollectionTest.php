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

    protected function getTransformer()
    {
        self::$transformer = self::$transformer ?? new PlayerToArrayDataTransformer();
        return self::$transformer;
    }

    public function transformerProvider()
    {
        return [[$this->getTransformer()]];
    }

    protected function getPlayerList()
    {
        self::$list = self::$list ?? new DoctrinePlayerListCollection($this->getTransformer());
        return self::$list;
    }

    public function ValidSetOfPlayersDataProvider()
    {
        return [[[
            ["num"=>6, "role"=>"PIVOT", "rating"=>6, "label"=>"Pivot 6","created"=>strtotime('+1 second')],
            ["num"=>4, "role"=>"ALERO", "rating"=>4, "label"=>"Alero 4","created"=>null],
            ["num"=>9, "role"=>"ESCOLTA", "rating"=>9, "label"=>"Escolta 9","created"=>strtotime('+1 second')],
            ["num"=>2, "role"=>"BASE", "rating"=>2, "label"=>"Base 2","created"=>strtotime('now')],
            ["num"=>0, "role"=>"BASE", "rating"=>0, "label"=>"Base 0","created"=>null],
            ["num"=>3, "role"=>"ALERO", "rating"=>3, "label"=>"Alero 3","created"=>strtotime('+1 second')],
            ["num"=>5, "role"=>"ALERO", "rating"=>5, "label"=>"Alero 5","created"=>strtotime('now')],
            ["num"=>7, "role"=>"PIVOT", "rating"=>7, "label"=>"Pivot 7","created"=>null],
            ["num"=>1, "role"=>"BASE", "rating"=>1, "label"=>"Base 1","created"=>null],            
            ["num"=>8, "role"=>"PIVOT", "rating"=>8, "label"=>"Pivot 8","created"=>strtotime('now')],
        ]]];
    }

    public function ValidSetOfPlayersProvider()
    {
        $players = $this->ValidSetOfPlayersDataProvider();
        $players = reset($players);
        $players = reset($players);
        $result = array_map(array($this->getTransformer(),'createPlayer'),$players);
        return [[$result]];
    }
    

    /**
     * @dataProvider transformerProvider
     */
    public function testConstructor($transformer)
    {
        $player_list = new DoctrinePlayerListCollection(self::$transformer);
        $this->assertInstanceOf(DoctrinePlayerListCollection::class,$player_list);
        $this->assertCount(0,$player_list,"Constructor does not reset the count");
        return $player_list;
    }

    /**
     * @dataProvider ValidSetOfPlayersDataProvider
     */
    public function testList($array_of_players)
    {
        $player_list = $this->getMockBuilder(DoctrinePlayerListCollection::class)
                            ->setMethods(['toArray'])
                            ->setConstructorArgs([$this->getTransformer()])
                            ->getMock();
        $player_list->method('toArray')->willReturn($array_of_players);
        $this->assertIsArray($player_list->list(),"List does not return an array");
        $this->assertCount(count($array_of_players),$player_list->list(),"List does not return all collected Players");    
    }


    /**
     * @dataProvider ValidSetOfPlayersProvider
     * @depends testList
     */
    public function testAppend($players)
    {
        $transformer = $this->getTransformer();
        $player_list = $this->getPlayerList();
        foreach($players as $player){
            $list = $player_list->list();
            $count = count($list);
            $player_list->append($player);
            $list = $player_list->list();
            $last_player =end($list);
            $transformed_player = $transformer->transform($player);
            $transformed_player_last_player = $transformer->transform($last_player);
            $this->assertEquals($transformed_player, $transformed_player_last_player,"Append does not add the player at the end");
            $this->assertCount($count+1,$list,"Append does not increase the list count");
        }
        return $player_list;
    }

    /**
     * @dataProvider ValidSetOfPlayersProvider
     * @depends testAppend
     */
    public function testHas($players,$player_list)
    {
        $player_list = $player_list ?? $this->getPlayerList();
        foreach($players as $player)
            $this->assertTrue($player_list->has($player),"Exists does not detect a collected Player");
        return $player_list;
    }

    /**
     * @dataProvider ValidSetOfPlayersProvider
     * @depends testAppend
     * @depends testHas     
     */
    public function testAppendTwiceThrowsException($players,$player_list)
    {
        $player_list = $player_list ?? $this->getPlayerList();        
        $this->expectException(\InvalidArgumentException::class);        
        foreach($players as $player){
            if ($player_list->has($player))
                $player_list->append($player);
        }
        return $player_list;
    }

    /**
     * @depends testList
     * @depends testAppend
     */
    public function testListContents($player_list)
    {
        $player_list = $player_list ?? $this->getPlayerList();
        $result = $player_list->list();
        $this->assertInstanceOf(Player::class, reset($result),"List function does not return an array of players");
        $this->assertInstanceOf(Player::class, next($result),"List function does not return an array of players");
        $this->assertInstanceOf(Player::class, end($result),"List function does not return an array of players");
        return $player_list;
    }

    /**
     * @depends testListContents
     */
    public function testSortByRole($player_list)
    {
        $player_list = $player_list ?? $this->getPlayerList();
        $player_list->sort("role");                
        $result = $player_list->list();
        $first = reset($result);                        
        $second = next($result);
        while($first && $second){
            $this->assertLessThanOrEqual($second->role()->value(),$first->role()->value(),"Sort method does not reorder the results by role");
            $first = current($result);
            $second = next($result);
        }
        return $player_list;  
    }
    /**
     * @depends testSortByRole
     */
    public function testSortByNum($player_list)
    {
        $player_list = $player_list ?? $this->getPlayerList();
        $player_list->sort("num");
        $result = $player_list->list();        
        $first = reset($result);                        
        $second = next($result);
        while($first && $second){
            $this->assertLessThanOrEqual($second->num()->value(),$first->num()->value(),"Sort method does not reorder the results by num");
            $first = current($result);
            $second = next($result);
        }                

    }

    /**
     * @depends testSortByRole
     * @depends testSortByNum
     */
    public function testReSortFromRoleToNum($player_list)
    {
        $player_list = $player_list ?? $this->getPlayerList();
        $player_list->sort("role");
        $player_list->sort("num");
        $result = $player_list->list();        
        $first = reset($result);                        
        $second = next($result);
        while($first && $second){
            $this->assertLessThanOrEqual($second->num()->value(),$first->num()->value(),"Sort method does not reorder the results by num after sorted once by role");
            $first = current($result);
            $second = next($result);
        }
        return $player_list;
    }

    /**
     * @dataProvider ValidSetOfPlayersDataProvider
     * @depends testListContents
     */
    public function testSortByNone($players,$player_list)
    {
        $player_list = $player_list ?? $this->getPlayerList();
        $transformer = $this->getTransformer();
        $player_list->sort();
        $result = $player_list->list();
       
        $first_sorted = reset($result);
        $second_sorted = next($result);
        $first_player = reset($players);
        $second_player = next($players);
        while($first_sorted && $second_sorted){
            $first_sorted = $transformer->transform($first_sorted);
            $second_sorted = $transformer->transform($second_sorted);
            // "created" PROPERTY IS INITIALIZED DURING LIST PLAYERS FEED,
            // SO TEST DATA MAY DIFFER IN THIS PROPERTY FROM FED LIST
            $first_player['created'] = $first_sorted['created'];
            $second_player['created'] = $second_sorted['created'];

            $this->assertEquals($first_player,$first_sorted,"Sort by none property does not recover the original order");
            $this->assertEquals($second_player,$second_sorted,"Sort by none property does not recover the original order");
            $first_player = current($players);
            $second_player = next($players);            
            $first_sorted = current($result);
            $second_sorted = next($result);
        }
        return $player_list;
    }


    /**
     * @dataProvider ValidSetOfPlayersProvider
     * @depends testHas
     */
    public function testExtract($players, $player_list){
        $player_list = $player_list ?? $this->getPlayerList();
        $transformer = $this->getTransformer();
        foreach ($players as $player) {
            $count = count($player_list->list());
            if ($player_list->has($player)) {
                $extracted_player = $player_list->extract($player->num());
                $extracted_player_data = $transformer->transform($extracted_player);
                $player_data = $transformer->transform($player);                
                // "created" PROPERTY IS INITIALIZED DURING LIST PLAYERS FEED,
                // SO TEST DATA MAY DIFFER IN THIS PROPERTY FROM FED LIST
                $player_data['created'] = $extracted_player_data['created'];
                $this->assertCount($count-1, $player_list->list(), "Extract does not increase the list count");
                $this->assertInstanceOf(Player::class, $extracted_player, "Extract does not return a Player instance");
                $this->assertEquals($player_data, $extracted_player_data, "Extract does not return the right Player");
            }
        }
        return $player_list;
    }

    /**
     * @dataProvider ValidSetOfPlayersProvider
     * @depends testExtract
     * @depends testHas     
     */
    public function testExtractTwiceThrowsException($players,$player_list)
    {

        $player_list = $player_list ?? $this->getPlayerList();
        $this->expectException(\InvalidArgumentException::class);        

        foreach ($players as $player) {
            $count = count($player_list->list());
            if ($player_list->has($player)) {
                $player_list->extract($player->num());
            }
            $player_list->extract($player->num());
        }
        return $player_list;
    }



}