<?php

declare(strict_types=1);

namespace Rszewc\Thecats\HttpClient;

use Rszewc\Thecats\Exception\ApiException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Psr\Log\NullLogger;
use Psr\Log\LoggerAwareTrait;
use Psr\Http\Message\ResponseInterface;

class ThecatsHttpClient
{
    use LoggerAwareTrait;

    /**
     * @var string
     */
    private $baseUri = 'https://api.thecatapi.com';

    /**
     * @var Client 
     */
    private $httpClient;

    /**
     * @param string $apiToken
     */
    public function __construct(string $apiToken)
    {
        $this->logger = new NullLogger();
        $this->httpClient = new Client([
            'base_uri' => $this->baseUri,
            'headers' => [
                'x-api-key' => $apiToken,
            ],
        ]);
    }

    /**
     * @param string $path
     * @param array $parameters
     * @param array $requestHeaders
     * @return ResponseInterface
     */
    public function httpGet(string $path, array $parameters = []) : ?ResponseInterface
    {
        if (count($parameters) > 0) {
            $path .= '?'.http_build_query($parameters);
        }
        try {
            $response = $this->httpClient->get($path);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }
        return $response;
    }
}