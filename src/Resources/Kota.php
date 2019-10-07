<?php

namespace Kavist\RajaOngkir\Resources;

use Kavist\RajaOngkir\HttpClients\AbstractClient;

class Kota extends AbstractLocation
{
    /**
     * @param \Kavist\RajaOngkir\HttpClients\AbstractClient $httpClient
     */
    public function __construct(AbstractClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->httpClient->setEntity('city');
        $this->httpClient->setHttpMethod('GET');
    }

    /**
     * @return self
     */
    public function setSearchColumn()
    {
        $this->searchDriver->setSearchColumn('city_name');

        return $this;
    }

    /**
     * @param int $provinceId
     * @return self
     */
    public function dariProvinsi(int $provinceId): self
    {
        $this->result = $this->httpClient->request(['province' => $provinceId]);

        return $this;
    }
}
