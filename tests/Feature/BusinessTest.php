<?php

namespace Tests\Feature;

use Mockery;
use App\Deal;
use App\User;
use App\Business;
use Tests\TestCase;
use GuzzleHttp\Client;
use Tests\TestGeocoderResponses;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->app->extend(Client::class, function ($client) {
            $mockClient = Mockery::mock($client)
                ->shouldReceive('get')
                ->once()
                ->andReturnSelf()
                ->shouldReceive('getBody')
                ->andReturn(TestGeocoderResponses::getCityResponse());

            return $mockClient->getMock();
        });
    }

    public function testItCanReturnABusinesses()
    {
        $business = factory(Business::class)->create();

        $response = $this->json('GET', '/businesses/'. $business->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $business->name]);
    }

    public function testABusinessUserCanCreateABusiness()
    {
        $user = factory(User::class)->create([
            'business_user' => true
        ]);

        $requestData = [
            'name' => 'Test Business',
            'street_address' => '123 fake street',
            'city' => 'Asheville',
            'state' => 'NC',
            'phone' => '5555555555',
            'summary' => 'A quick description of the Test Business',
        ];

        $response = $this->actingAs($user)->json('POST', '/businesses/', $requestData);

        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => $requestData['name']]);
        $this->assertDatabaseHas('businesses', ['name' => $requestData['name']]);
    }

    public function testOnlyABusinessUserCanCreateABusiness()
    {
        $user = factory(User::class)->create([
            'business_user' => false
        ]);

        $requestData = [
            'name' => 'Test Business',
            'street_address' => '123 fake street',
            'city' => 'Asheville',
            'state' => 'NC',
            'phone' => '5555555555',
            'summary' => 'A quick description of the Test Business',
        ];

        $response = $this->actingAs($user)->json('POST', '/businesses/', $requestData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('businesses', ['name' => $requestData['name']]);
    }

    public function testBusinessRequestClassValidatesData()
    {
        $user = factory(User::class)->create([
            'business_user' => true
        ]);

        $requestData = [
            'name' => 10,
            'state' => 'North Carolina',
            'summary' => 'A quick description of the Test Business',
        ];

        $response = $this->actingAs($user)->json('POST', '/businesses/', $requestData);

        $response->assertStatus(422);
        $response->assertJsonFragment(['name' => ['Name is an invalid data type']]);
        $response->assertJsonFragment(['city' => ['You must specify the city that your business is located in']]);
        $response->assertJsonFragment(['state' => ['Please use your State\'s 2 letter abbreviation']]);
        $this->assertDatabaseMissing('businesses', ['summary' => $requestData['summary']]);
    }

    public function testABusinessCanBeUpdated()
    {
        $user = factory(User::class)->create([
            'business_user' => true
        ]);

        $business = factory(Business::class)->create([
            'user_id' => $user->id
        ]);

        $requestData = [
            'summary' => 'A different summary than the one before',
        ];

        $response = $this->actingAs($user)->json('PATCH', '/businesses/' . $business->id , $requestData);

        $response->assertStatus(200);
        $response->assertJsonFragment(['summary' => $requestData['summary']]);
        $this->assertDatabaseHas('businesses', ['summary' => $requestData['summary']]);
    }

    public function testABusinessCanOnlybeUpdatedByTheUserWhoOwnsIt()
    {
        list($userOwner, $userNotOwner) = factory(User::class, 2)->create([
            'business_user' => true
        ]);

        $business = factory(Business::class)->create([
            'user_id' => $userOwner->id
        ]);

        $response = $this->actingAs($userNotOwner)->json(
            'PATCH',
            '/businesses/' . $business->id, 
            ['name' => 'A Different Company']);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('businesses', ['name' => 'A Different Company']);
    }

    public function testABusinessCanBeDestroyed()
    {
        $user = factory(User::class)->create([
            'business_user' => true
        ]);

        $business = factory(Business::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->json('DELETE', '/businesses/' . $business->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('businesses', ['id' => $business->id]);
    }
}
