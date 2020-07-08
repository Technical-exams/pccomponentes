<?php namespace Basket\Tests\Integration;

use Basket\Application\DataTransformers\Players\PlayerToArrayDataTransformer;
use Basket\Application\DataTransformers\Players\PlayerDataTransformer;
use Basket\Domain\Players\Player;
use Basket\Domain\Players\PlayerNumValueObject;
use Basket\Infrastructure\Players\Doctrine\DoctrineInMemoryPlayerDataSource;
use Basket\Infrastructure\Players\InMemory\InMemoryPlayersRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as TestCase;

class InMemoryPlayersRepositoryTest extends TestCase
{

    protected static $transformer;

    public function getTransformer() : PlayerDataTransformer 
    {
        self::$transformer = self::$transformer ?? new PlayerToArrayDataTransformer();
        return self::$transformer;
    }

    public function emptyDataSourceProvider(){
        return [[new DoctrineInMemoryPlayerDataSource($this->getTransformer())]];
    }

    public function testFakeAdd(){
        $player = new Player(0,'Zero Player', 'BASE', 0);
        $data_source = $this->createMock(DoctrineInMemoryPlayerDataSource::class);
        $data_source->expects($this->once())
                    ->method('fetchOne')
                    ->with($this->isInstanceOf(PlayerNumValueObject::class))
                    ->will($this->returnValue(null));
        $data_source->expects($this->once())
                    ->method('insert')
                    ->with($this->isInstanceOf(Player::class));                    
        $repository = new InMemoryPlayersRepository($data_source);
        $old_player = $repository->add($player);
        $this->assertNull($old_player,"Add new player returns unexpected result");
    }

    /**
     * @depends testFakeAdd
     * @dataProvider emptyDataSourceProvider
     */
    public function testAdd($data_source){
        
        $time = new \DateTime();
        $initial_player = new Player(0,'Zero Player', 'BASE', 0 , $time);
        $new_player = new Player(0,'New Zero Player', 'ALERO', 9);
        
        $repository = new InMemoryPlayersRepository($data_source);
        $null_player = $repository->add($initial_player);
        
        $former_player = $repository->add($new_player);

        $updated_player = $repository->add($initial_player);

        $transformer = $this->getTransformer();
        $initial_player_data = $transformer->transform($initial_player);
        $former_player_data = $transformer->transform($former_player);
        $new_player_data = $transformer->transform($new_player);
        $updated_player_data = $transformer->transform($updated_player);

        $this->assertNull($null_player,"Test precondition failed when adding repeated player");
        $this->assertEquals($initial_player_data,$former_player_data,"Add does not return the previous player state");
        $this->assertEquals($new_player_data,$updated_player_data,"Add does not return the previous player state");        
        
        return $repository;
    }


    public function testFakeRemove(){
        $player = new Player(0,'Zero Player', 'BASE', 0);
        $data_source = $this->createMock(DoctrineInMemoryPlayerDataSource::class);
        $data_source->expects($this->once())
                    ->method('fetchOne')
                    ->with($this->isInstanceOf(PlayerNumValueObject::class))
                    ->will($this->returnValue($player));
        $data_source->expects($this->once())
                    ->method('delete')
                    ->with($this->isInstanceOf(PlayerNumValueObject::class));                    
        $repository = new InMemoryPlayersRepository($data_source);
        $old_player = $repository->remove($player->num());
        $this->assertInstanceOf(Player::class,$old_player,"Remove existing player returns unexpected result");
    }
    
    /**
     * @depends testAdd
     * @depends testFakeRemove
     * @dataProvider emptyDataSourceProvider
     */
    public function testRemove($data_source){
        $player = new Player(0,'Zero Player', 'BASE', 0 );
        
        $repository = new InMemoryPlayersRepository($data_source);
        $unexisting_player = $repository->remove($player->num());
        $repository->add($player);
        $existing_player = $repository->remove($player->num());
        $removed_player = $repository->remove($player->num());

        $transformer = $this->getTransformer();
        $player_data = $transformer->transform($player);
        $existing_player_data = $transformer->transform($existing_player);        

        $this->assertNull($unexisting_player,"Remove unexisting player returns unexpected result");
        $this->assertEquals($player_data,$existing_player_data, "Remove existing player does now return the player removed");
        $this->assertNull($removed_player,"Remove does not actually drops players from Repo");
    }

    public function testFakeFindAll(){
        $data_source = $this->createMock(DoctrineInMemoryPlayerDataSource::class);
        $data_source->expects($this->once())
                    ->method('fetchAll')
                    ->with($this->isType("array"));
        $repository = new InMemoryPlayersRepository($data_source);
        $repository->findAll();
    }
    
    /**
     * @depends testAdd
     * @dataProvider emptyDataSourceProvider
     */
    public function testFindAll($data_source){
        $repository = new InMemoryPlayersRepository($data_source);

        $result = $repository->findAll();        
        $this->assertIsArray($result,"FindAll does not return an array");
        $player = new Player(666,'The Beast','PIVOT', 100);
        $zero_player = new Player(0,'Zero Player', 'BASE', 0 );

        $repository->add($player);
        $repository->add($zero_player);

        $result = $repository->findAll();
        
        $this->assertInstanceOf(Player::class,end($result),"FindAll does not return players");
        $this->assertCount(2,$result,"FindAll does not return the expected number of players");
    }

    public function testFakeFindAllOrderBy()
    {

    }

    public function testFindAllOrderBy()
    {
        
    }

}
