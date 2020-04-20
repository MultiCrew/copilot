<?php

namespace Tests\Feature;

use App\Models\Flights\Flight;
use App\Models\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FlightInteractionTest extends TestCase
{
    protected $flight;
    protected $user1, $user2;

    public function setUp(): void
    {
        $this->user1 = factory(User::class)->make();
        $this->user2 = factory(User::class)->make();

        $this->flight = Flight::create([
            'departure'     => 'EGPD',
            'arrival'       => 'EHAM',
            'aircraft'      => 'B738',
            'public'        => 1,
            'requestee_id'  => $user1->id
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
        $this->assertTrue($this->flight->isInvolved($user1));
        $this->assertFalse($this->flight->isInvolved($user2));
        $this->assertEquals(null, $this->flight->acceptee);
    }

    /**
     * Tests accepting a Flight request
     *
     * @return void
     */
    public function testFlightAccept()
    {
        $this->actingAs($user2);
        $this->flight->accept();

        $this->assertEquals($this->user2, $this->flight->acceptee);
        $this->assertTrue($this->flight->isAcceptee($this->user2));
        $this->assertTrue($this->flight->isInvolved($user2));
        $this->assertTrue($this->flight->isAccepted());
    }

    public function tearDown(): void
    {
        $this->user1 = null;
        $this->user2 = null;
        $this->flight = null;
    }
}
