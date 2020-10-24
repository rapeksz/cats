<?php

declare(strict_types=1);

namespace Rszewc\Thecats\HttpClient;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    /**
     * @param string $path
     * @param array $parameters
     * @return ResponseInterface
     */
    public function httpGet(string $path, array $parameters = []) : ?ResponseInterface;

    /**
     * @param string $path
     * @param array $parameters
     * @return ResponseInterface
     */
    public function httpPost(string $path, array $parameters = []) : ?ResponseInterface;

    /**
     * @param string $path
     * @return ResponseInterface
     */
    public function httpDelete(string $path) : ?ResponseInterface;
}