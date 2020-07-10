<?php namespace Basket\Infrastructure\Command\CSV;

use Basket\Application\Command\CommandTracker;
use Basket\Application\Events\RequestEvent;
use League\Csv\Writer;
use Basket\Application\Factories\DataTransformers\RequestEventDataTransformerFactory;


class CSVCommandTracker
    extends CommandTracker
{

    protected $provider;

    protected $registry_path;

    public function __construct(RequestEventDataTransformerFactory $factory, string $commandRegistryPath)
    {
        parent::__construct($factory);
        $this->registry_path = $commandRegistryPath;
        try{
            $this->provider = Writer::createFromPath($this->registry_path,'a+');
        }catch(\Throwable $error){
            $this->provider = Writer::createFromFileObject(new \SplTempFileObject(1024));
            throw $error;
        }
    }

    public function track(RequestEvent $commandEvent){
        $data = $this->getTransformer($commandEvent)->transform($commandEvent);
        $this->provider->insertOne($data);
    }

}
