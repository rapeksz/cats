<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Api;

use Rszewc\Thecats\Api\HttpApi;
use Psr\Http\Message\ResponseInterface;

class Votes extends HttpApi
{
    /**
     * @return ResponseInterface
     */
    public function showAll() : ResponseInterface
    {
        $response = $this->httpClient->httpGet('/v1/votes');
        //todo: add class to prepareResponse to define which type of objects must returns
        return $this->prepareResponse($response);
    }
}