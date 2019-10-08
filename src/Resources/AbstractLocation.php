<?php

namespace Kavist\RajaOngkir\Resources;

use Kavist\RajaOngkir\Contracts\LocationResourceContract;
use Kavist\RajaOngkir\Contracts\SearchDriverContract;

abstract class AbstractLocation extends AbstractResource implements LocationResourceContract
{
    /** @var \Kavist\RajaOngkir\Contracts\SearchDriverContract */
    protected $searchDriver;

    /**
     * @param \Kavist\RajaOngkir\Contracts\SearchDriverContract $searchDriver
     * @return self
     */
    public function setSearchDriver(SearchDriverContract $searchDriver)
    {
        $this->searchDriver = $searchDriver;

        return $this;
    }

    /**
     * @return self
     */
    abstract public function setSearchColumn();

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->httpClient->request();
    }

    /**
     * @param int|string $id
     * @return array
     */
    public function find($id): array
    {
        return $this->httpClient->request(compact('id'));
    }

    /**
     * @param string $searchTerm
     * @return self
     */
    public function search(string $searchTerm)
    {
        if (empty($this->result)) {
            $this->result = $this->all();
        }

        $this->result = $this->searchDriver->setData($this->result)->search($searchTerm);

        return $this;
    }
}
