<?php

namespace Kavist\RajaOngkir\HttpClients;

use EngineException;
use Kavist\RajaOngkir\Exceptions\ApiResponseException;
use Kavist\RajaOngkir\Exceptions\BasicHttpClientException;

class BasicClient extends AbstractClient
{
    /** @var resource */
    protected $context;

    /** @var array */
    protected $contextOptions = [
        'max_redirects' => 5,
        'timeout' => 30,
        'protocol_version' => 1.1,
        'method' => 'GET',
    ];

    public function request(array $payload = []): array
    {
        $contextOptions = [
            'method' => $this->httpMethod,
            'header' => $this->buildHttpHeaders(),
        ];

        if ('POST' === $this->httpMethod) {
            $contextOptions['content'] = http_build_query($payload);
        }

        $this->initialize($contextOptions);

        return $this->executeRequest($this->buildUrl($payload));
    }

    protected function initialize(array $contextOptions = [])
    {
        $this->context = stream_context_create([
            'http' => array_merge($this->contextOptions, $contextOptions),
        ]);
    }

    protected function buildUrl(array $payload = []): string
    {
        $url = parent::buildUrl();

        if ('GET' === $this->httpMethod) {
            $url .= '?'.http_build_query($payload);
        }

        return $url;
    }

    private function buildHttpHeaders(): string
    {
        $headers = $this->httpHeaders;

        if ('POST' === $this->httpMethod) {
            $headers += ['Content-Type' => 'application/x-www-form-urlencoded'];
        }

        foreach ($headers as $headerKey => $headerValue) {
            $headers[$headerKey] = $headerKey.':'.$headerValue."\r\n";
        }

        return implode($headers);
    }

    private function executeRequest(string $url): array
    {
        set_error_handler(function ($severity, $message) {
            throw new BasicHttpClientException('Client Error: '.$message, $severity);
        });

        $rawResponse = file_get_contents($url, false, $this->context);

        restore_error_handler();

        $this->stopIfClientReturnsError($rawResponse);

        $response = json_decode($rawResponse, true)['rajaongkir'];

        $this->stopIfApiReturnsError($response['status']);

        return $response['results'];
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
