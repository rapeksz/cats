<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Tests\Api;

use Rszewc\Thecats\Api\Votes;
use Rszewc\Thecats\HttpClient\HttpClientInterface;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;
use Rszewc\Thecats\Model\Vote;
use Rszewc\Thecats\Model\ApiResponse;
use GuzzleHttp\Psr7\Response;

class VotesTest extends TestCase
{
    /**
     * @var HttpClientInterface 
     */
    private $httpClient;

    /**
     * @return void
     */
    protected function setUp(): void 
    {
        parent::setUp();
        $this->httpClient = $this->getMockBuilder(HttpClientInterface::class)
                ->disableOriginalConstructor()
                ->getMock();
    }
    
    public function testShowAll()
    {
        $data = [
            [
                'image_id' => '1234',
                'value' => 1234,
            ]
        ];
        $response = new Response(200, [], json_encode($data));
        $this->httpClient->expects($this->once())
                ->method('httpGet')
                ->willReturn($response);
        $votes = new Votes($this->httpClient);
        $votesCollection = $votes->showAll();
        $this->assertInstanceOf(Collection::class, $votesCollection);
    }
    
    public function testCreate()
    {
        $response = new Response(200, [], json_encode([]));
        $this->httpClient->expects($this->once())
                ->method('httpPost')
                ->willReturn($response);
        $votes = new Votes($this->httpClient);
        $vote = Vote::create([
            'image_id' => '1234',
            'value' => 1234,
        ]);
        $apiResponse = $votes->create($vote);
        $this->assertInstanceOf(ApiResponse::class, $apiResponse);
    }
    
    public function testGetById()
    {
        $response = new Response(200, [], json_encode([
            'image_id' => '1234',
            'value' => 1234,
        ]));
        $this->httpClient->expects($this->once())
                ->method('httpGet')
                ->willReturn($response);
        $votes = new Votes($this->httpClient);
        $vote = $votes->getById(1234);
        $this->assertInstanceOf(Vote::class, $vote);
    }
    
    
    public function testDeleteById()
    {
        $response = new Response(200, [], json_encode([]));
        $this->httpClient->expects($this->once())
                ->method('httpDelete')
                ->willReturn($response);
        $votes = new Votes($this->httpClient);
        $apiResponse = $votes->deleteById(1234);
        $this->assertInstanceOf(ApiResponse::class, $apiResponse);
    }
}