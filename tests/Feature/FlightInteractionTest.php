<?php

namespace Tests\Feature;

use App\Models\Flights\Flight;
use App\Models\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlightInteractionTest extends TestCase
{
    use RefreshDatabase;

    protected $flight;
    protected $user1, $user2;

    public function setUp(): void
    {
        parent::setUp();

        $this->user1 = new User();
        $this->user1->fill([
            'name'      => 'Test User 1',
            'username'  => 'test1',
            'email'     => 'test1@test.com',
            'password'  => ''
        ]);
        $this->user1->save();

        $this->user2 = new User();
        $this->user2->fill([
            'name'      => 'Test User 2',
            'username'  => 'test2',
            'email'     => 'test2@test.com',
            'password'  => ''
        ]);
        $this->user2->save();

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
        $this->assertEquals($this->user1->id, $this->flight->requestee->id);
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
        $this->flight->acceptee_id = $this->user2->id;

        $this->assertEquals($this->user2->id, $this->flight->acceptee->id);
        $this->assertTrue($this->flight->isAcceptee($this->user2));
        $this->assertTrue($this->flight->isInvolved($this->user2));
        $this->assertTrue($this->flight->isAccepted());
    }

    public function tearDown(): void
    {
        $this->user1 = null;
        $this->user2 = null;
        $this->flight = null;

        parent::tearDown();
    }
}