<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Api;

use Rszewc\Thecats\Model\ApiResponse;
use Rszewc\Thecats\Exception\ApiException;
use Rszewc\Thecats\HttpClient\ThecatsHttpClient;
use Psr\Http\Message\ResponseInterface;

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

    protected function prepareResponse(ResponseInterface $response, string $class = '')
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode < 200 || $statusCode > 299) {
            throw new ApiException(
                sprintf('[%d] Error connecting to the API.', $statusCode), 
                $statusCode, 
                $response
            );
        }
        return $this->buildResponse($response, $class);
    }

    private function buildResponse(ResponseInterface $response, string $class = '')
    {
        $body = $response->getBody()->__toString();
        $data = json_decode($body, true);
        if (is_subclass_of($class, ApiResponse::class)) {
            $object = call_user_func($class . '::create', $data);
        } else {
            $object = new $class($data);
        }
        return $object;
    }
}