<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Api;

use Rszewc\Thecats\Exception\ApiException;
use Rszewc\Thecats\HttpClient\ThecatsHttpClient;
use Rszewc\Thecats\Model\StatusResponse;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Support\Collection;

abstract class HttpApi
{
    /**
     * @var ThecatsHttpClient 
     */
    protected $httpClient;

    /**
     * @param ThecatsHttpClient $httpClient
     */
    public function __construct(ThecatsHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws ApiException
     */
    protected function prepareResponse(ResponseInterface $response) : ResponseInterface
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode < 200 || $statusCode > 299) {
            throw new ApiException(
                sprintf('[%d] Error connecting to the API.', $statusCode), 
                $statusCode, 
                $response
            );
        }
        return $response;
    }

    /**
     * @param ResponseInterface $response
     * @return StatusResponse
     */
    protected function buildStatusResponse(ResponseInterface $response) : StatusResponse
    {
        $body = $response->getBody()->__toString();
        $bodyDecoded = json_decode($body, true);
        $statusResponse = StatusResponse::create($bodyDecoded);
        return $statusResponse;
    }

    /**
     * @param ResponseInterface $response
     * @param string $class
     * @return Collection
     */
    protected function buildCollection(ResponseInterface $response, string $class) : Collection
    {
        $data = $this->decodeResponse($response);
        $objects = call_user_func($class . '::createFromArray', $data);
        return $objects;
    }

    /**
     * @param ResponseInterface $response
     * @param string $class
     * @return type
     */
    protected function buildObject(ResponseInterface $response, string $class)
    {
        $data = $this->decodeResponse($response);
        $objects = call_user_func($class . '::create', $data);
        return $objects;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    private function decodeResponse(ResponseInterface $response) : array
    {
        $body = $response->getBody()->__toString();
        return json_decode($body, true);
    }
}