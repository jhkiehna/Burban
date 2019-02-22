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

    public function testItCanGeocode()
    {
        $geocoder = new GoogleGeocoder();
        
        $response = $geocoder->geocode('asheville');

        $this->assertEquals($response, 'ChIJCW8PPKmMWYgRXTo0BsEx75Q');
    }

    public function testItCanAddTheOptionalArguments()
    {   
        $geocoder = new GoogleGeocoder('en', 'testregion');

        $geocoder->geocode('asheville');
    }

    public function testItThrowsANoResultExceptionWhenNoResponse()
    {
        $geocoder = new GoogleGeocoder();

        try {
            $geocoder->geocode('asheville');
        } catch (\Exception $e) {
            $this->assertEquals(NoResult::class, get_class($e));
        }
    }

    public function testItThrowsAnAccessDeniedException()
    {
        $this->app->extend(Client::class, function ($client) {
            $client
                ->shouldReceive('getBody')
                ->andReturn(TestGeocoderResponses::getAccessDeniedResponse());

            return $client;
        });

        $geocoder = new GoogleGeocoder();

        try {
            $geocoder->geocode('asheville');
        } catch (\Exception $e) {
            $this->assertEquals(AccessDenied::class, get_class($e));
        }
    }

    public function testItThrowsAnInvalidKeyExceptionWhenBadKey()
    {
        $this->app->extend(Client::class, function ($client) {
            $client
                ->shouldReceive('getBody')
                ->andReturn(TestGeocoderResponses::getInvalidKeyResponse());

            return $client;
        });

        $geocoder = new GoogleGeocoder();

        try {
            $geocoder->geocode('asheville');
        } catch (\Exception $e) {
            $this->assertEquals(InvalidKey::class, get_class($e));
        }
    }

    public function testItThrowsAQuotaExceededException()
    {
        $this->app->extend(Client::class, function ($client) {
            $client
                ->shouldReceive('getBody')
                ->andReturn(TestGeocoderResponses::getQuotedExceededResponse());

            return $client;
        });

        $geocoder = new GoogleGeocoder();

        try {
            $geocoder->geocode('asheville');
        } catch (\Exception $e) {
            $this->assertEquals(QuotaExceeded::class, get_class($e));
        }
    }

    public function testItThrowsANoResultsExceptionWhenResponseIsEmpty()
    {
        $this->app->extend(Client::class, function ($client) {
            $client
                ->shouldReceive('getBody')
                ->andReturn(TestGeocoderResponses::getNoResultsResponse());

            return $client;
        });

        $geocoder = new GoogleGeocoder();

        try {
            $geocoder->geocode('asheville');
        } catch (\Exception $e) {
            $this->assertEquals(NoResult::class, get_class($e));
        }
    }
}
