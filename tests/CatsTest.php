<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Tests;

use Rszewc\Thecats\HttpClient\ThecatsHttpClient;
use Rszewc\Thecats\Cats;
use Rszewc\Thecats\Api\Votes;
use PHPUnit\Framework\TestCase;

class CatsTest extends TestCase
{
    /**
     * @var Cats 
     */
    private $cats;

    /**
     * @return void
     */
    protected function setUp(): void 
    {
        parent::setUp();
        $httpClient = $this->getMockBuilder(ThecatsHttpClient::class)
                ->disableOriginalConstructor()
                ->getMock();
        $this->cats = new Cats($httpClient);
    }
    
    public function testVotes()
    {
        $votes = $this->cats->votes();
        $this->assertInstanceOf(Votes::class, $votes);
    }
}