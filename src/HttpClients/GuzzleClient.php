<?php

namespace Kavist\RajaOngkir\HttpClients;

use EngineException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Kavist\RajaOngkir\Exceptions\ApiResponseException;
use Kavist\RajaOngkir\Exceptions\BasicHttpClientException;

class GuzzleClient extends AbstractClient
{
    public function request(array $payload = []): array
    {
        try {
            $client = new Client();
            $response = $client->request($this->httpMethod, $this->buildUrl($payload), [
                'headers' => $this->buildHttpHeaders(),
                'form_params' => $payload
            ]);
            $rawData = $response->getBody();
            $data = json_decode($rawData, true)['rajaongkir'];
            
            $this->stopIfApiReturnsError($data['status']);

            return $data['results'];
        } catch(ClientException $clientException) {
            throw new BasicHttpClientException('Client Error');
        }
    }

    protected function buildUrl(array $payload = []): string
    {
        $url = parent::buildUrl();

        if ('GET' === $this->httpMethod) {
            $url .= '?'.http_build_query($payload);
        }

        return $url;
    }

    private function buildHttpHeaders(): array
    {
        $headers = $this->httpHeaders;

        if ('POST' === $this->httpMethod) {
            $headers += ['Content-Type' => 'application/x-www-form-urlencoded'];
        }

        foreach ($headers as $headerKey => $headerValue) {
            $headers[$headerKey] = $headerKey.':'.$headerValue."\r\n";
        }

        return $headers;
    }

    private function stopIfClientReturnsError($status)
    {
        if (false === $status) {
            throw new BasicHttpClientException('Client Error');
        }
    }

    private function stopIfApiReturnsError(array $status)
    {
        if (400 == $status['code']) {
            throw new ApiResponseException('RajaOngkir API Error: '.$status['description']);
        }
    }
}
