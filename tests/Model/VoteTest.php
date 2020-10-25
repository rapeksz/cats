<?php

declare(strict_types=1);

namespace Rszewc\Thecats\Tests\Model;

use Rszewc\Thecats\Model\Vote;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class VoteTest extends TestCase
{
    /**
     * @var Vote 
     */
    private $vote;
    
    /**
     * @return void
     */
    protected function setUp(): void 
    {
        parent::setUp();
        $this->vote = Vote::create([
            'image_id' => '1234',
            'value' => 1234,
            'created_at' => '2020-10-25',
        ]);
    }
    
    public function testCreate()
    {
        $vote = $this->vote->create($this->vote->__toArray());
        $createdAt = $vote->__toArray()['created_at'];
        $this->assertInstanceOf(Vote::class, $this->vote);
        $this->assertInstanceOf(CarbonInterface::class, $createdAt);
    }
    
    public function testCreateFromArray()
    {
        $votes = Vote::createFromArray([
            $this->vote->__toArray(),
        ]);
        $this->assertCount(1, $votes);
        $this->assertInstanceOf(Collection::class, $votes);
    }
    
    public function testToArray()
    {
        $voteArray = $this->vote->__toArray();
        $this->assertIsArray($voteArray);
    }
    
    public function testJsonSerialize()
    {
        $json = $this->vote->jsonSerialize();
        $this->assertJson($json);
    }
}

