<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Tests\Model;

use Rszewc\Thecats\Model\StatusResponse;
use PHPUnit\Framework\TestCase;

class StatusResponseTest extends TestCase
{
    /**
     * @var array 
     */
    private $statusData;
    
    /**
     * @return void
     */
    protected function setUp(): void 
    {
        parent::setUp();
        $this->statusData = [
            'message' => 'test',
            'id' => 1234,
        ];
    }
    
    public function testCreate()
    {
        $statusResponse = StatusResponse::create($this->statusData);
        $this->assertInstanceOf(StatusResponse::class, $statusResponse);
    }
    
    public function testGetMessage()
    {
        $statusEmptyResponse = new StatusResponse();
        $emptyString = $statusEmptyResponse->getMessage();
        $this->assertNull($emptyString);
        $statusResponse = StatusResponse::create($this->statusData);
        $string = $statusResponse->getMessage();
        $this->assertIsString($string);
    }
    
    public function testGetId()
    {
        $statusEmptyResponse = new StatusResponse();
        $emptyId = $statusEmptyResponse->getId();
        $this->assertNull($emptyId);
        $statusResponse = StatusResponse::create($this->statusData);
        $id = $statusResponse->getId();
        $this->assertIsInt($id);
    }
}