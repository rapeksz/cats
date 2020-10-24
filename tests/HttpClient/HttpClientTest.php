<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Tests\HttpClient;

use Psr\Http\Message\ResponseInterface;
use Rszewc\Thecats\HttpClient\ThecatsHttpClient;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class HttpClientTest extends TestCase
{
    /**
     * @var ThecatsHttpClient 
     */
    private $httpClient;
    
    /**
     * @return void
     */
    protected function setUp(): void 
    {
        parent::setUp();
        $this->httpClient = new ThecatsHttpClient('test');
        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], 'Hello, World'),
            new Response(202, ['Content-Length' => 0]),
            new RequestException('Error Communicating with Server', new Request('GET', 'test')),
            new ClientException('Error Communicating with Server', new Request('GET', 'test'), new Response(401)),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $reflection = new ReflectionClass($this->httpClient);
        $reflectionProperty = $reflection->getProperty('httpClient');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->httpClient, $client);
    }

    public function testHttpGet()
    {
        $result = $this->httpClient->httpGet('/votes/v1', ['foo' => 'bar']);
        $this->assertInstanceof(ResponseInterface::class, $result);
    }
    
    public function testHttpPost()
    {
        $result = $this->httpClient->httpPost('/votes/v1', ['foo' => 'bar']);
        $this->assertInstanceof(ResponseInterface::class, $result);
    }
    
    public function testHttpDelete()
    {
        $result = $this->httpClient->httpDelete('/votes/v1');
        $this->assertInstanceof(ResponseInterface::class, $result);
    }
}