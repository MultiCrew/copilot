<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Users\User;
use App\Models\Flights\Flight;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlightInteractionTest extends TestCase
{
    protected $flight;
    protected $user1, $user2;

	public function setUp(): void
    {
        $this->user1 = factory(User::class)->create();
        $this->user2 = factory(User::class)->create();

        $this->flight = Flight::create([
            'departure'     => 'EGPD',
            'arrival'       => 'EHAM',
            'aircraft'      => 'B738',
            'public'        => 1,
            'requestee_id'  => $this->user1->id
        ]);
    }

    /**
     * Tests that the flight requestee is the correct user
     *
     * @return void
     */
    public function testRequestee()
    {
        $this->assertEquals($this->user1, $this->flight->requestee);
        $this->assertTrue($this->flight->isRequestee($this->user1));
        $this->assertTrue($this->flight->isInvolved($this->user1));
        $this->assertFalse($this->flight->isInvolved($this->user2));
        $this->assertEquals(null, $this->flight->acceptee);
    }

    /**
     * Tests accepting a Flight request
     *
     * @return void
     */
    public function testFlightAccept()
    {
        $this->actingAs($this->user2);
        $this->flight->accept();

        $this->assertEquals($this->user2, $this->flight->acceptee);
        $this->assertTrue($this->flight->isAcceptee($this->user2));
        $this->assertTrue($this->flight->isInvolved($this->user2));
        $this->assertTrue($this->flight->isAccepted());
    }

    public function tearDown(): void
    {
        $this->user1 = null;
        $this->user2 = null;
        $this->flight = null;
    }
}
