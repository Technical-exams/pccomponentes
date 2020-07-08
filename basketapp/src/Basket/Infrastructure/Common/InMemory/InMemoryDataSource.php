<?php namespace Basket\Infrastructure\Common\InMemory;

interface InMemoryDataSource
{
    public function fetchAll(array $orderBy) : array;

    public function insert($object);

    public function delete($object_id);

    public function fetchOne($object_id);


}