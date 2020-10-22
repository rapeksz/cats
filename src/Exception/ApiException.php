<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Exception;

use Rszewc\Thecats\Exception\Exception;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class ApiException extends RuntimeException implements Exception
{
    /**
     * @var ResponseInterface 
     */
    private $response;
    
    /**
     * @var array
     */
    private $responseBody = [];

    /**
     * @var int
     */
    private $responseCode;

    /**
     * @param string $message
     * @param int $code
     * @param ResponseInterface $response
     */
    public function __construct(string $message, int $code, ResponseInterface $response)
    {
        parent::__construct($message, $code);

        $this->response = $response;
        $this->responseCode = $response->getStatusCode();
    }

    /**
     * @return ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function getResponseBody(): array
    {
        return $this->responseBody;
    }

    /**
     * @return int
     */
    public function getResponseCode(): int
    {
        return $this->responseCode;
    }
}