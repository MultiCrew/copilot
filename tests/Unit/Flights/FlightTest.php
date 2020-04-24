<?php

namespace Tests\Unit\Flights;

use App\Models\Flights\FlightRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlightTest extends TestCase
{
    protected $flight;

    public function setUp(): void
    {
        $this->flight = new FlightRequest();
        $this->flight->fill([
            'departure' => 'EGPD',
            'arrival'   => 'EHAM',
            'aircraft'  => 'B738'
        ]);
    }

    /**
     * Tests that FlightRequest has been created correctly
     *
     * @return void
     */
    public function testflightCreation()
    {
        $this->assertEquals('EGPD', $this->flight->departure);
        $this->assertEquals('EHAM', $this->flight->arrival);
        $this->assertEquals('B738', $this->flight->aircraft);
    }

    /**
     * Tests the isPublic() method for a public flight
     *
     * @return void
     */
    public function testpublicFlight()
    {
        $this->flight->public = 1;

        $this->assertTrue($this->flight->isPublic());
    }

    /**
     * Tests that a newly created flight has no plan
     *
     * @return void
     */
    public function testUnPlannedFlight()
    {
        $this->assertFalse($this->flight->isPlanned());
    }

    /**
     * Tests that a newly created flight's non existent plan is not accepted
     *
     * @return void
     */
    public function testUnPlannedFlightAccepted()
    {
        $this->assertFalse($this->flight->planAccepted());
    }

    /**
     * Tests the isPublic() method for a private flight
     *
     * @return void
     */
    public function testprivateFlight()
    {
        $this->flight->public = 0;

        $this->assertFalse($this->flight->isPublic());
    }

    public function tearDown(): void
    {
        $this->flight = null;
    }
}
