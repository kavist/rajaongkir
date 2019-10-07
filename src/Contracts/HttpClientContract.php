<?php

namespace Kavist\RajaOngkir\Contracts;

interface HttpClientContract
{
    /**
     * @param string $apiKey
     * @return self
     */
    public function setApiKey(string $apiKey);

    /**
     * @param string $package
     * @return self
     */
    public function setPackage(string $package);

    /**
     * @param string $entity
     * @return self
     */
    public function setEntity(string $entity);

    /**
     * @param string $httpMethod
     * @return self
     */
    public function setHttpMethod(string $httpMethod);

    /**
     * @param array $payload
     * @return array
     */
    public function request(array $payload = []): array;
}
