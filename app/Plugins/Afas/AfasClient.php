<?php

namespace App\Plugins\Afas;

use App\Plugins\Afas\AfasConfig;

use Illuminate\Support\Facades\Http;
use Throwable;
use Illuminate\Http\Client\Response;

class RequestException extends \Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class AfasClient
{
    private const DEFAULT_FILTER = "?skip=0&take=100000";

    /**
     * Headers for the HTTP requests.
     *
     * @var array
     */
    private array $headers;

    /**
     * Configuration object containing base64Token, urlEndpoint and integrationID.
     *
     * @var AfasConfig
     */
    private AfasConfig $config;

    public function __construct(AfasConfig $config)
    {
        $this->config = $config;

        $this->headers = [
            'Content-Type' => 'application/json',
            'Authorization' => "AfasToken {$config->base64Token}",
        ];

        if (!empty($this->config->integrationID)) {
            $this->headers['IntegrationId'] = $config->integrationID;
        }
    }

    private function createRequestException(Response $response): RequestException
    {
        $data = $response->json();

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            return new RequestException('Invalid JSON response', $response->status());
        }

        $message = $data['message'] ?? $data['externalMessage'] ?? $response->body();
        return new RequestException($message, $response->status());
    }

    private function sendRequest(string $method, string $endpoint, array $data = [], string $filter = null): ?array
    {
        $url = $this->config->urlEndpoint . $endpoint . ($filter ?? self::DEFAULT_FILTER);
        $response = Http::withHeaders($this->headers)->{$method}($url, $data);

        if ($response->successful()) {
            $data =  $response->json();

            if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                return $data;
            }
        }

        throw $this->createRequestException($response);
    }

    public function get(string $endpoint, string $filter = null): ?array
    {
        return $this->sendRequest('get', $endpoint, [], $filter);
    }

    public function put(string $endpoint, array $data): ?array
    {
        return $this->sendRequest('put', $endpoint, $data);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}