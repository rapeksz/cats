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
use Illuminate\Support\Collection;
use Rszewc\Thecats\Model\Vote;
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

    public function testBuildCollection()
    {
        $body = json_encode([
            [
                'image_id' => '1234',
                'value' => 1234,
            ]
        ]);
        $params = [
            new Response(200, [], $body),
            Vote::class,
        ];
        $response = $this->invokeMethod($this->httpApi, 'buildCollection', $params);
        $this->assertInstanceOf(Collection::class, $response);
    }

    public function testBuildObject()
    {
        $body = json_encode([
            'image_id' => '1234',
            'value' => 1234,
        ]);
        $params = [
            new Response(200, [], $body),
            Vote::class,
        ];
        $response = $this->invokeMethod($this->httpApi, 'buildObject', $params);
        $this->assertInstanceOf(Vote::class, $response);
    }

    public function testDecodeResponse()
    {
        $params = [
            new Response(200, [], json_encode([])),
            Vote::class,
        ];
        $response = $this->invokeMethod($this->httpApi, 'decodeResponse', $params);
        $this->assertIsArray($response);
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