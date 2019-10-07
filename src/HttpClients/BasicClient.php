<?php

namespace Kavist\RajaOngkir\HttpClients;

use Kavist\RajaOngkir\Exceptions\ApiResponseException;
use Kavist\RajaOngkir\Exceptions\BasicHttpClientException;

class BasicClient extends AbstractClient
{
    /** @var resource */
    protected $curl;

    /** @var array */
    protected $curlOptions = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    ];

    public function request(array $payload = []): array
    {
        $curlOptions = [
            CURLOPT_CUSTOMREQUEST => $this->httpMethod,
            CURLOPT_URL => $this->buildUrl($payload),
            CURLOPT_HTTPHEADER => $this->buildHttpHeaders(),
        ];

        if ('POST' === $this->httpMethod) {
            $curlOptions[CURLOPT_POSTFIELDS] = http_build_query($payload);
        }

        $this->initialize($curlOptions);

        return $this->executeRequest();
    }

    protected function initialize(array $curlOptions = [])
    {
        $this->curl = curl_init();
        curl_setopt_array($this->curl, $this->curlOptions + $curlOptions);
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
            $headers[$headerKey] = $headerKey.':'.$headerValue;
        }

        return array_values($headers);
    }

    private function executeRequest(): array
    {
        $rawResponse = curl_exec($this->curl);
        $errno = curl_errno($this->curl);
        curl_close($this->curl);

        $this->stopIfClientReturnsError($errno);

        $response = json_decode($rawResponse, true)['rajaongkir'];

        $this->stopIfApiReturnsError($response['status']);

        return $response['results'];
    }

    private function stopIfClientReturnsError(int $errno): void
    {
        if ($errno) {
            throw new BasicHttpClientException('cURL Error: '.curl_strerror($errno), $errno);
        }
    }

    private function stopIfApiReturnsError(array $status): void
    {
        if (400 == $status['code']) {
            throw new ApiResponseException('RajaOngkir API Error: '.$status['description']);
        }
    }
}
