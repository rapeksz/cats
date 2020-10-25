<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Tests\HttpApi;

use PHPUnit\Framework\TestCase;
use Rszewc\Thecats\Api\HttpApi;
use Rszewc\Thecats\Model\StatusResponse;
use Rszewc\Thecats\HttpClient\ThecatsHttpClient;
use Rszewc\Thecats\Exception\ApiException;
use ReflectionClass;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class HttpApiTest extends TestCase
{
    /**
     *
     * @var HttpApi 
     */
    private $httpApi;
    /**
     * @return void
     */
    protected function setUp(): void 
    {
        parent::setUp();
        $httpClient = new ThecatsHttpClient('test');
        $this->httpApi = $this->getMockForAbstractClass(HttpApi::class, [$httpClient]);
    }
    
    public function testPrepareResponse()
    {
        $response = $this->invokeMethod($this->httpApi, 'prepareResponse', [new Response(200)]);
        $this->assertEquals($response->getStatusCode(), 200);
    }
    
    public function testPrepareResponseThrowsException()
    {
        $this->expectException(ApiException::class);
        $this->invokeMethod($this->httpApi, 'prepareResponse', [new Response(401)]);
    }
    
    public function testBuildStatusResponse()
    {
        $body = json_encode([
            'message' => 'test',
            'id' => 1234,
        ]);
        $params = [
            new Response(200, [], $body),
        ];
        $response = $this->invokeMethod($this->httpApi, 'buildStatusResponse', $params);
        $this->assertInstanceOf(StatusResponse::class, $response);
    }

    /**
     * @param mixed $object
     * @param string $methodName
     * @param array $parameters
     * @return mixed
     */
    private function invokeMethod(&$object, string $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
}