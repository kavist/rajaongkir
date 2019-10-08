<?php

namespace Kavist\RajaOngkir\Contracts;

interface LocationResourceContract
{
    /**
     * @param \Kavist\RajaOngkir\Contracts\SearchDriverContract $searchDriver
     * @return self
     */
    public function setSearchDriver(SearchDriverContract $searchDriver);

    /**
     * @return self
     */
    public function setSearchColumn();

    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param int|string $id
     * @return array
     */
    public function find($id): array;

    /**
     * @return array
     */
    public function get(): array;

    /**
     * @param string $searchTerm
     * @return self
     */
    public function search(string $searchTerm);
}
