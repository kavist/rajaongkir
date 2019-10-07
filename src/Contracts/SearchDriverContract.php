<?php

namespace Kavist\RajaOngkir\Contracts;

interface SearchDriverContract
{
    /**
     * @param string $searchColumn
     * @return self
     */
    public function setSearchColumn(string $searchColumn);

    /**
     * @param array $collection
     * @return self
     */
    public function setData(array $collection);

    /**
     * @param string $searchQuery
     * @return array
     */
    public function search(string $searchQuery): array;
}
