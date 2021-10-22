<?php

namespace Kavist\RajaOngkir\Resources;

use Kavist\RajaOngkir\HttpClients\AbstractClient;

class CekWaybill extends AbstractResource
{
    /**
     * @param \Kavist\RajaOngkir\HttpClients\AbstractClient $httpClient
     */
    public function __construct(AbstractClient $httpClient, array $payload)
    {
        $this->httpClient = $httpClient;
        $this->httpClient->setEntity('waybill');
        $this->httpClient->setHttpMethod('POST');

        $this->callRequest($payload);
    }

    private function callRequest(array $payload)
    {
        $this->result = $this->httpClient->request($payload);
    }
}
