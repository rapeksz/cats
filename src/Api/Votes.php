<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Api;

use Rszewc\Thecats\Api\HttpApi;
use Rszewc\Thecats\Model\Vote;
use Rszewc\Thecats\Model\StatusResponse;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class Votes extends HttpApi
{
    /**
     * @return ResponseInterface
     */
    public function showAll() : Collection
    {
        $response = $this->httpClient->httpGet('/v1/votes');
        return $this->prepareResponse($response, Vote::class);
    }

    /**
     * @param Vote $vote
     * @return StatusResponse
     */
    public function create(Vote $vote) : StatusResponse
    {
        $parameters = $vote->__toArray();
        $response = $this->httpClient->httpPost('/v1/votes', $parameters);
        return $this->buildStatusResponse($response);
    }
}