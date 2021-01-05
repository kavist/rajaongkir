<?php

namespace Kavist\RajaOngkir\Resources;

abstract class AbstractResource
{
    /** @var array */
    private $result = [];

    /** @var \Kavist\RajaOngkir\HttpClients\AbstractClient */
    protected $httpClient;

    public function get(): array
    {
        return $this->result;
    }
}
