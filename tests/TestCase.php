<?php

namespace Tests;

use Mockery;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function getMockClient($responseData)
    {
        return Mockery::mock(Client::class)
            ->shouldReceive('get')
            ->andReturnSelf()
            ->shouldReceive('getBody')
            ->andReturn($responseData)
            ->mock();
    }
}
