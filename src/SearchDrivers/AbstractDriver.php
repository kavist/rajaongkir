<?php

namespace Kavist\RajaOngkir\SearchDrivers;

use Kavist\RajaOngkir\Contracts\SearchDriverContract;

abstract class AbstractDriver implements SearchDriverContract
{
    /** @var array */
    protected $collection;

    /** @var string */
    protected $searchColumn;

    /**
     * @param string $searchColumn
     * @return self
     */
    public function setSearchColumn(string $searchColumn)
    {
        $this->searchColumn = $searchColumn;

        return $this;
    }

    /**
     * @param array $collection
     * @return self
     */
    public function setData(array $collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return array
     */
    abstract public function search(string $searchQuery): array;
}
