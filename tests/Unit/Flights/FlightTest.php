<?php

namespace Tests\Unit\Flights;

use App\Models\Flights\Flight;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlightTest extends TestCase
{
    protected $flight;
    protected $user1, $user2;

    public function setUp(): void
    {
        $this->flight = new Flight();
        $this->flight->fill([
            'departure' => 'EGPD',
            'arrival'   => 'EHAM',
            'aircraft'  => 'B738'
        ]);
    }

    /**
     * Tests that Flight has been created correctly
     *
     * @return void
     */
    public function testflightCreationTest()
    {
        $this->assertEquals('EGPD', $this->flight->departure);
        $this->assertEquals('EHAM', $this->flight->arrival);
        $this->assertEquals('B738', $this->flight->aircraft);
    }

    public function tearDown(): void
    {
        $this->flight = null;
    }
}
