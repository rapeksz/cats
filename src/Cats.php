<?php

declare(strict_types=1);

namespace Rszewc\Thecats;

use Rszewc\Thecats\HttpClient\ThecatsHttpClient;
use Rszewc\Thecats\Api\Votes;

class Cats
{
    /**
     * @var ThecatsHttpClient 
     */
    private $httpClient;

    /**
     * @param ThecatsHttpClient $httpClient
     */
    public function __construct(ThecatsHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Votes
     */
    public function votes() : Votes
    {
        return new Votes($this->httpClient);
    }
}