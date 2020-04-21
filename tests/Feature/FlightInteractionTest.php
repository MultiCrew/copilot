<?php

namespace Tests\Feature;

use App\Models\Flights\FlightRequest;
use App\Models\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Auth;

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

        $this->flight = FlightRequest::create([
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
        $this->assertFalse($this->flight->isAcceptee($this->user1));
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
        $this->assertFalse($this->flight->isRequestee($this->user2));
        $this->assertTrue($this->flight->isInvolved($this->user2));
        $this->assertTrue($this->flight->isAccepted());
    }

    /**
     * Test the other user method
     *
     * @return void
     * @throws \Exception
     */
    public function testOtherUser()
    {
        // logged in as user1, the REQUESTEE
        $this->actingAs($this->user1);
        print_r("Authenticated as: ".Auth::id());
        // assert that the other user is null - THERE IS NO OTHER USER
        $this->assertEquals(null, $this->flight->otherUser());

        // accept the flight as user 2, the ACCEPTEE
        $this->flight->acceptee_id = $this->user2->id;
        print_r($this->flight);
        // assert that, from user1's perspective, user2 IS THE OTHER USER
        $this->assertEquals($this->user2->id, $this->flight->otherUser()->id);

        // now switch to logged in as user2, the ACCEPTEE
        $this->actingAs($this->user2);
        print_r("Authenticated as: ".Auth::id());
        // assert that, from user2's perspective, user1 IS THE OTHER USER
        $this->assertEquals($this->user1->id, $this->flight->otherUser()->id);
    }

    public function tearDown(): void
    {
        $this->user1 = null;
        $this->user2 = null;
        $this->flight = null;

        parent::tearDown();
    }
}
