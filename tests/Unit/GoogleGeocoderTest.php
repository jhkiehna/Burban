<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use GuzzleHttp\Client;
use Tests\TestGeocoderResponses;
use App\Services\Geocoder\GoogleGeocoder;
use App\Services\Geocoder\Exceptions\NoResult;
use App\Services\Geocoder\Exceptions\InvalidKey;
use App\Services\Geocoder\Exceptions\AccessDenied;
use App\Services\Geocoder\Exceptions\QuotaExceeded;

class GoogleGeocoderTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testItCanGeocode()
    {
        $mockClient = $this->getMockClient(TestGeocoderResponses::getCityResponse());
        $geocoder = new GoogleGeocoder($mockClient);
        $response = $geocoder->geocode('asheville');
        $first = array_pop($response);
        $this->assertEquals('Asheville, NC, USA', $first['address']);
        $this->assertEquals(35.5950581, $first['latitude']);
        $this->assertEquals(-82.5514869, $first['longitude']);
        $this->assertEquals('ChIJCW8PPKmMWYgRXTo0BsEx75Q', $first['place_id']);
        $this->assertEquals(['locality', 'political'], $first['types']);
        $this->assertEquals([
            'northeast' => [
                'latitude' => 35.656299,
                'longitude' => -82.4599379
            ],
            'southwest' => [
                'latitude' => 35.421565,
                'longitude' => -82.6708731
            ]
        ], $first['bounds']);
        $this->assertEquals('Asheville', $first['address_components']['locality']);
    }

    public function testItCanReverseGeocodeByAPlaceId()
    {
        $mockClient = $this->getMockClient(TestGeocoderResponses::getCityResponse());
        $geocoder = new GoogleGeocoder($mockClient);
        $response = $geocoder->reverseByPlaceId('ChIJCW8PPKmMWYgRXTo0BsEx75Q');
        $first = array_pop($response);
        $this->assertEquals('Asheville, NC, USA', $first['address']);
        $this->assertEquals(35.5950581, $first['latitude']);
        $this->assertEquals(-82.5514869, $first['longitude']);
        $this->assertEquals('ChIJCW8PPKmMWYgRXTo0BsEx75Q', $first['place_id']);
        $this->assertEquals(['locality', 'political'], $first['types']);
        $this->assertEquals([
            'northeast' => [
                'latitude' => 35.656299,
                'longitude' => -82.4599379
            ],
            'southwest' => [
                'latitude' => 35.421565,
                'longitude' => -82.6708731
            ]
        ], $first['bounds']);
    }

    public function testItCanReverseGeocodeByCoordinates()
    {
        $mockClient = $this->getMockClient(TestGeocoderResponses::getCityResponse());
        $geocoder = new GoogleGeocoder($mockClient);
        $response = $geocoder->reverseByPlaceId(35.5950581, -82.5514869);
        $first = array_pop($response);
        $this->assertEquals('Asheville, NC, USA', $first['address']);
        $this->assertEquals(35.5950581, $first['latitude']);
        $this->assertEquals(-82.5514869, $first['longitude']);
        $this->assertEquals('ChIJCW8PPKmMWYgRXTo0BsEx75Q', $first['place_id']);
        $this->assertEquals(['locality', 'political'], $first['types']);
        $this->assertEquals([
            'northeast' => [
                'latitude' => 35.656299,
                'longitude' => -82.4599379
            ],
            'southwest' => [
                'latitude' => 35.421565,
                'longitude' => -82.6708731
            ]
        ], $first['bounds']);
    }

    public function testItCanAddTheOptionalArguments()
    {
        $spyClient = Mockery::mock(Client::class)
            ->shouldReceive('get')
            ->once()
            ->with("https://maps.googleapis.com/maps/api/geocode/json?&key=testkey&language=en&region=testregion&address=asheville")
            ->andReturnSelf()
            ->shouldReceive('getBody')
            ->andReturn(TestGeocoderResponses::getCityResponse())
            ->getMock();
        $geocoder = new GoogleGeocoder($spyClient, 'testkey', 'en', 'testregion');
        $geocoder->geocode('asheville');
    }

    public function testItReturnsTheAddressComponents()
    {
        $mockClient = $this->getMockClient(TestGeocoderResponses::getCityResponse());
        $geocoder = new GoogleGeocoder($mockClient);
        $response = $geocoder->geocode('asheville');
        $first = array_pop($response);
        $this->assertEquals('Asheville', $first['address_components']['locality']);
        $this->assertEquals('North Carolina', $first['address_components']['administrative_area_level_1']);
        $this->assertEquals('United States', $first['address_components']['country']);
    }

    public function testItThrowsANoResultExceptionWhenNoResponse()
    {
        $mockClient = $this->getMockClient(null);
        $geocoder = new GoogleGeocoder($mockClient);
        try {
            $geocoder->geocode('asheville');
        } catch (\Exception $e) {
            $this->assertEquals(NoResult::class, get_class($e));
        }
    }

    public function testItThrowsAnAccessDeniedException()
    {
        $mockClient = $this->getMockClient(TestGeocoderResponses::getAccessDeniedResponse());
        $geocoder = new GoogleGeocoder($mockClient);
        try {
            $geocoder->geocode('asheville');
        } catch (\Exception $e) {
            $this->assertEquals(AccessDenied::class, get_class($e));
        }
    }

    public function testItThrowsAnInvalidKeyExceptionWhenBadKey()
    {
        $mockClient = $this->getMockClient(TestGeocoderResponses::getInvalidKeyResponse());
        $geocoder = new GoogleGeocoder($mockClient);
        try {
            $geocoder->geocode('asheville');
        } catch (\Exception $e) {
            $this->assertEquals(InvalidKey::class, get_class($e));
        }
    }

    public function testItThrowsAQuotaExceededException()
    {
        $mockClient = $this->getMockClient(TestGeocoderResponses::getQuotedExceededResponse());
        $geocoder = new GoogleGeocoder($mockClient);
        try {
            $geocoder->geocode('asheville');
        } catch (\Exception $e) {
            $this->assertEquals(QuotaExceeded::class, get_class($e));
        }
    }

    public function testItThrowsANoResultsExceptionWhenResponseIsEmpty()
    {
        $mockClient = $this->getMockClient(TestGeocoderResponses::getNoResultsResponse());
        $geocoder = new GoogleGeocoder($mockClient);
        try {
            $geocoder->geocode('asheville');
        } catch (\Exception $e) {
            $this->assertEquals(NoResult::class, get_class($e));
        }
    }
}